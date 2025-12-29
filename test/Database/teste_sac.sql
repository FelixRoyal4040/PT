-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 29, 2025 at 08:44 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `teste_sac`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_cargo`
--

CREATE TABLE `tb_cargo` (
  `id` int(11) NOT NULL,
  `nome` varchar(80) NOT NULL,
  `descricao` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_consulta`
--

CREATE TABLE `tb_consulta` (
  `id` int(11) NOT NULL,
  `horario_id` int(11) NOT NULL,
  `paciente_id` int(11) NOT NULL,
  `status` enum('Pendente','Confirmada','Concluída','Cancelada') DEFAULT 'Pendente',
  `observacoes` longtext DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_especialidade`
--

CREATE TABLE `tb_especialidade` (
  `id` int(11) NOT NULL,
  `nome` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_funcionario`
--

CREATE TABLE `tb_funcionario` (
  `id` int(11) NOT NULL,
  `us_id` int(11) NOT NULL,
  `data_admissao` date NOT NULL,
  `nome_completo` varchar(120) NOT NULL,
  `cargo_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_horario`
--

CREATE TABLE `tb_horario` (
  `id` int(11) NOT NULL,
  `medico_id` int(11) NOT NULL,
  `data` date NOT NULL,
  `hora_inicio` time NOT NULL,
  `hora_fim` time NOT NULL,
  `disponivel` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_medico`
--

CREATE TABLE `tb_medico` (
  `id` int(11) NOT NULL,
  `funcionario_id` int(11) NOT NULL,
  `status` enum('ativo','afastado') DEFAULT 'ativo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_medico_especialidade`
--

CREATE TABLE `tb_medico_especialidade` (
  `medico_id` int(11) NOT NULL,
  `especialidade_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_paciente`
--

CREATE TABLE `tb_paciente` (
  `id` int(11) NOT NULL,
  `us_id` int(11) NOT NULL,
  `nome_completo` varchar(120) NOT NULL,
  `data_nascimento` date NOT NULL,
  `sexo` enum('M','F') NOT NULL,
  `telefone` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_perfil`
--

CREATE TABLE `tb_perfil` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_us`
--

CREATE TABLE `tb_us` (
  `id` int(11) NOT NULL,
  `email` varchar(120) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` enum('ativo','inativo') DEFAULT 'ativo',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_us_perfil`
--

CREATE TABLE `tb_us_perfil` (
  `us_id` int(11) NOT NULL,
  `perfil_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_cargo`
--
ALTER TABLE `tb_cargo`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nome` (`nome`);

--
-- Indexes for table `tb_consulta`
--
ALTER TABLE `tb_consulta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `horario_id` (`horario_id`),
  ADD KEY `paciente_id` (`paciente_id`);

--
-- Indexes for table `tb_especialidade`
--
ALTER TABLE `tb_especialidade`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nome` (`nome`);

--
-- Indexes for table `tb_funcionario`
--
ALTER TABLE `tb_funcionario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `us_id` (`us_id`),
  ADD KEY `cargo_id` (`cargo_id`);

--
-- Indexes for table `tb_horario`
--
ALTER TABLE `tb_horario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `medico_id` (`medico_id`);

--
-- Indexes for table `tb_medico`
--
ALTER TABLE `tb_medico`
  ADD PRIMARY KEY (`id`),
  ADD KEY `funcionario_id` (`funcionario_id`);

--
-- Indexes for table `tb_medico_especialidade`
--
ALTER TABLE `tb_medico_especialidade`
  ADD PRIMARY KEY (`medico_id`,`especialidade_id`),
  ADD KEY `especialidade_id` (`especialidade_id`);

--
-- Indexes for table `tb_paciente`
--
ALTER TABLE `tb_paciente`
  ADD PRIMARY KEY (`id`),
  ADD KEY `us_id` (`us_id`);

--
-- Indexes for table `tb_perfil`
--
ALTER TABLE `tb_perfil`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nome` (`nome`);

--
-- Indexes for table `tb_us`
--
ALTER TABLE `tb_us`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `tb_us_perfil`
--
ALTER TABLE `tb_us_perfil`
  ADD PRIMARY KEY (`us_id`,`perfil_id`),
  ADD KEY `perfil_id` (`perfil_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_cargo`
--
ALTER TABLE `tb_cargo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_consulta`
--
ALTER TABLE `tb_consulta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_especialidade`
--
ALTER TABLE `tb_especialidade`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_funcionario`
--
ALTER TABLE `tb_funcionario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_horario`
--
ALTER TABLE `tb_horario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_medico`
--
ALTER TABLE `tb_medico`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_paciente`
--
ALTER TABLE `tb_paciente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_perfil`
--
ALTER TABLE `tb_perfil`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_us`
--
ALTER TABLE `tb_us`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_consulta`
--
ALTER TABLE `tb_consulta`
  ADD CONSTRAINT `tb_consulta_ibfk_1` FOREIGN KEY (`horario_id`) REFERENCES `tb_horario` (`id`),
  ADD CONSTRAINT `tb_consulta_ibfk_2` FOREIGN KEY (`paciente_id`) REFERENCES `tb_paciente` (`id`);

--
-- Constraints for table `tb_funcionario`
--
ALTER TABLE `tb_funcionario`
  ADD CONSTRAINT `tb_funcionario_ibfk_1` FOREIGN KEY (`us_id`) REFERENCES `tb_us` (`id`),
  ADD CONSTRAINT `tb_funcionario_ibfk_2` FOREIGN KEY (`cargo_id`) REFERENCES `tb_cargo` (`id`);

--
-- Constraints for table `tb_horario`
--
ALTER TABLE `tb_horario`
  ADD CONSTRAINT `tb_horario_ibfk_1` FOREIGN KEY (`medico_id`) REFERENCES `tb_medico` (`id`);

--
-- Constraints for table `tb_medico`
--
ALTER TABLE `tb_medico`
  ADD CONSTRAINT `tb_medico_ibfk_1` FOREIGN KEY (`funcionario_id`) REFERENCES `tb_funcionario` (`id`);

--
-- Constraints for table `tb_medico_especialidade`
--
ALTER TABLE `tb_medico_especialidade`
  ADD CONSTRAINT `tb_medico_especialidade_ibfk_1` FOREIGN KEY (`medico_id`) REFERENCES `tb_medico` (`id`),
  ADD CONSTRAINT `tb_medico_especialidade_ibfk_2` FOREIGN KEY (`especialidade_id`) REFERENCES `tb_especialidade` (`id`);

--
-- Constraints for table `tb_paciente`
--
ALTER TABLE `tb_paciente`
  ADD CONSTRAINT `tb_paciente_ibfk_1` FOREIGN KEY (`us_id`) REFERENCES `tb_us` (`id`);

--
-- Constraints for table `tb_us_perfil`
--
ALTER TABLE `tb_us_perfil`
  ADD CONSTRAINT `tb_us_perfil_ibfk_1` FOREIGN KEY (`us_id`) REFERENCES `tb_us` (`id`),
  ADD CONSTRAINT `tb_us_perfil_ibfk_2` FOREIGN KEY (`perfil_id`) REFERENCES `tb_perfil` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
