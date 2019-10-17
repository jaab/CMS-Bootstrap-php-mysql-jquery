-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: 17-Out-2019 às 18:00
-- Versão do servidor: 5.7.28-log
-- versão do PHP: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `clinica`
--
CREATE DATABASE IF NOT EXISTS `clinica` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `viseu_dnm`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `consultas`
--

CREATE TABLE `consultas` (
  `id_consulta` int(5) NOT NULL,
  `id_medico` int(3) DEFAULT NULL,
  `id_paciente` int(3) DEFAULT NULL,
  `id_esp` int(2) NOT NULL,
  `data_consulta` varchar(100) NOT NULL,
  `hora_consulta` varchar(100) NOT NULL,
  `estado` enum('S','N') NOT NULL,
  `internamento` enum('S','N','A') NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `consultas`
--

INSERT INTO `consultas` (`id_consulta`, `id_medico`, `id_paciente`, `id_esp`, `data_consulta`, `hora_consulta`, `estado`, `internamento`) VALUES
(17, 1, 2, 2, '7-15-2019', '9:00', 'S', 'N'),
(18, 1, 2, 4, '7-16-2019', '20:00', 'S', 'N'),
(19, 3, 2, 5, '7-19-2019', '17:00', 'S', 'N'),
(22, 2, 2, 1, '7-23-2019', '11:00', 'S', 'N'),
(33, 2, 3, 1, '7-26-2019', '21:00', 'S', 'A'),
(37, 2, 2, 6, '8-09-2019', '16:00', 'S', 'N'),
(38, 1, 3, 4, '8-22-2019', '16:00', 'S', 'N'),
(40, 2, 2, 1, '7-30-2019', '19:00', 'S', 'N'),
(41, 2, 2, 1, '7-29-2019', '15:00', 'S', 'N'),
(42, 1, 2, 2, '7-30-2019', '20:00', 'S', 'N'),
(43, 1, 4, 2, '7-31-2019', '16:00', 'S', 'S'),
(44, 1, 5, 2, '8-02-2019', '16:00', 'S', 'N');

-- --------------------------------------------------------

--
-- Estrutura da tabela `especialidades`
--

CREATE TABLE `especialidades` (
  `id_esp` int(2) NOT NULL,
  `descricao` varchar(50) NOT NULL,
  `estado` enum('S','N') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `especialidades`
--

INSERT INTO `especialidades` (`id_esp`, `descricao`, `estado`) VALUES
(1, 'Oftalmologia', 'S'),
(2, 'Cardiologia', 'S'),
(4, 'Ortopedia', 'S'),
(5, 'Pediatria', 'S'),
(6, 'Clinica Geral', 'S');

-- --------------------------------------------------------

--
-- Estrutura da tabela `funcionarios`
--

CREATE TABLE `funcionarios` (
  `id_funcionario` int(3) NOT NULL,
  `nome_funcionario` varchar(50) NOT NULL,
  `morada` varchar(100) DEFAULT NULL,
  `telefone` int(9) DEFAULT NULL,
  `funcao` varchar(50) NOT NULL,
  `foto` varchar(100) DEFAULT NULL,
  `data_nascimento` varchar(10) NOT NULL,
  `nif` varchar(10) NOT NULL,
  `sexo` varchar(10) NOT NULL,
  `estado` enum('S','N') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `login`
--

CREATE TABLE `login` (
  `id` int(3) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `acesso` int(2) NOT NULL,
  `estado` enum('S','N') NOT NULL,
  `data` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `email_user` varchar(50) NOT NULL,
  `nif` varchar(10) NOT NULL,
  `termos` enum('S','N') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `login`
--

INSERT INTO `login` (`id`, `username`, `password`, `acesso`, `estado`, `data`, `email_user`, `nif`, `termos`) VALUES
(56, 'jaab', '204a2fcde96cd19e47ac3b3bf058c8ac', 1, 'S', '2019-09-04 13:54:15', 'jabatista@msn.com', '208967982', NULL),
(86, 'manel', '95ab6cdfaa9d646f83061a936bfb8996', 3, 'S', '2019-07-31 14:39:49', 'jaabguru@gmail.com', '208967982', NULL),
(87, 'paulo', 'dd41cb18c930753cbecf993f828603dc', 3, 'S', '2019-09-11 13:20:57', 'pauloantonioalmeidacunha@gmail.com', '245675987', NULL),
(88, 'julio', 'c027636003b468821081e281758e35ff', 2, 'S', '2019-09-11 13:18:16', 'jaabguru@gmail.com', '234567865', NULL),
(94, 'antonia', '4a6f93feab73fbe7b10942a4a4e4b83c', 2, 'S', '2019-07-30 10:29:45', 'antonia@gmail.com', '352626236', ''),
(95, 'antonio', '4a181673429f0b6abbfd452f0f3b5950', 3, 'S', '2019-07-31 14:18:49', 'antonio@sapo.pt', '234567908', NULL),
(96, 'carlos', 'dc599a9972fde3045dab59dbd1ae170b', 2, 'S', '2019-07-31 05:17:38', 'player@viseu.tv', '208967983', ''),
(97, 'joao', 'dccd96c256bc7dd39bae41a405f25e43', 2, 'S', '2019-07-31 15:32:49', 'joaonatividade046@gmail.com', '23456789', ''),
(98, 'Test', 'd9f6e636e369552839e7bb8057aeb8da', 2, 'S', '2019-08-02 15:02:16', 'test@test.com', '2456759875', '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `medicos`
--

CREATE TABLE `medicos` (
  `id_medico` int(3) NOT NULL,
  `nome_medico` varchar(50) NOT NULL,
  `morada` varchar(100) NOT NULL,
  `telefone` int(9) DEFAULT NULL,
  `foto` varchar(100) DEFAULT NULL,
  `nif` varchar(10) NOT NULL,
  `data_nascimento` varchar(10) NOT NULL,
  `sexo` varchar(10) NOT NULL,
  `estado` enum('S','N') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `medicos`
--

INSERT INTO `medicos` (`id_medico`, `nome_medico`, `morada`, `telefone`, `foto`, `nif`, `data_nascimento`, `sexo`, `estado`) VALUES
(1, 'Manuel Albuquerque dos Santos', 'rua da mola, 3500-001 Viseu', 919786389, 'bf386e1f42cc598a11deb137f15b94f1.jpg', '208967982', '22-07-1978', 'Masculino', 'S'),
(2, 'Paulo Antonio de Almeida Cunha', 'coimbra', 2352352, '0f1476120c5b191a9e52d0835df0f78a.jpg', '245675987', '20-06-1967', 'Masculino', 'S'),
(3, 'Antonio Miguel Sousa Lemos', 'Lisboa', 919768328, '09171699e1855c555255d72bfbebfeea.jpg', '234567908', '21-08-1996', 'Masculino', 'S');

-- --------------------------------------------------------

--
-- Estrutura da tabela `med_esp`
--

CREATE TABLE `med_esp` (
  `id_medico` int(3) NOT NULL,
  `id_esp` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `med_esp`
--

INSERT INTO `med_esp` (`id_medico`, `id_esp`) VALUES
(2, 1),
(1, 2),
(1, 4),
(3, 5),
(2, 6);

-- --------------------------------------------------------

--
-- Estrutura da tabela `pacientes`
--

CREATE TABLE `pacientes` (
  `id_paciente` int(10) NOT NULL,
  `nome_paciente` varchar(50) NOT NULL,
  `morada` varchar(100) NOT NULL,
  `telefone` int(9) DEFAULT NULL,
  `foto` varchar(100) DEFAULT NULL,
  `nif` varchar(10) NOT NULL,
  `data_nascimento` varchar(10) NOT NULL,
  `sexo` varchar(10) NOT NULL,
  `estado` enum('S','N') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `pacientes`
--

INSERT INTO `pacientes` (`id_paciente`, `nome_paciente`, `morada`, `telefone`, `foto`, `nif`, `data_nascimento`, `sexo`, `estado`) VALUES
(2, 'JÃºlio Moreno Caxias Monteiro', 'Santa comba DÃ£o', 939765432, 'b257e96eef6e45fc1065ccdf37d48a43.jpg', '234567865', '12-07-1982', 'Masculino', 'S'),
(3, 'Antonia maria carneiro lopes', 'viseu', 242423421, '14c0269f2883539fa2393b7465e13f67.jpg', '352626236', '20-06-1977', 'Feminino', 'S'),
(4, 'Carlos AntÃ³nio LibÃ³rio', 'Vouzela', 23245678, NULL, '208967983', '21-08-1996', 'Masculino', 'S'),
(5, 'JoÃ£o morais', 'lisboa', 353634634, 'b8b2dda2bafe7f73a8238d7bc22641cc.png', '23456789', '21-08-1996', 'Masculino', 'S'),
(6, 'nuno mota', 'viseu', 12412412, NULL, '2456759875', '22/07/1978', 'Masculino', 'N');

-- --------------------------------------------------------

--
-- Estrutura da tabela `prescricao`
--

CREATE TABLE `prescricao` (
  `id_prescricao` int(5) NOT NULL,
  `id_consulta` int(5) DEFAULT NULL,
  `prescricao` text NOT NULL,
  `observacoes` varchar(255) NOT NULL,
  `estado` enum('S','N') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `prescricao`
--

INSERT INTO `prescricao` (`id_prescricao`, `id_consulta`, `prescricao`, `observacoes`, `estado`) VALUES
(2, 33, '1 comprimido de manha e outro à noite', 'beber sempre agua antes', 'S'),
(4, 43, '1 Xarope gastramil, 1 comprimido para a tosse', 'todos dias de manhÃ£', 'S');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `consultas`
--
ALTER TABLE `consultas`
  ADD PRIMARY KEY (`id_consulta`),
  ADD KEY `id_medico` (`id_medico`),
  ADD KEY `id_paciente` (`id_paciente`);

--
-- Indexes for table `especialidades`
--
ALTER TABLE `especialidades`
  ADD PRIMARY KEY (`id_esp`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `medicos`
--
ALTER TABLE `medicos`
  ADD PRIMARY KEY (`id_medico`);

--
-- Indexes for table `med_esp`
--
ALTER TABLE `med_esp`
  ADD PRIMARY KEY (`id_medico`,`id_esp`),
  ADD KEY `id_esp` (`id_esp`);

--
-- Indexes for table `pacientes`
--
ALTER TABLE `pacientes`
  ADD PRIMARY KEY (`id_paciente`);

--
-- Indexes for table `prescricao`
--
ALTER TABLE `prescricao`
  ADD PRIMARY KEY (`id_prescricao`),
  ADD KEY `id_consulta` (`id_consulta`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `consultas`
--
ALTER TABLE `consultas`
  MODIFY `id_consulta` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `especialidades`
--
ALTER TABLE `especialidades`
  MODIFY `id_esp` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- AUTO_INCREMENT for table `medicos`
--
ALTER TABLE `medicos`
  MODIFY `id_medico` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pacientes`
--
ALTER TABLE `pacientes`
  MODIFY `id_paciente` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `prescricao`
--
ALTER TABLE `prescricao`
  MODIFY `id_prescricao` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `consultas`
--
ALTER TABLE `consultas`
  ADD CONSTRAINT `consultas_ibfk_1` FOREIGN KEY (`id_medico`) REFERENCES `medicos` (`id_medico`),
  ADD CONSTRAINT `consultas_ibfk_2` FOREIGN KEY (`id_paciente`) REFERENCES `pacientes` (`id_paciente`);

--
-- Limitadores para a tabela `med_esp`
--
ALTER TABLE `med_esp`
  ADD CONSTRAINT `med_esp_ibfk_1` FOREIGN KEY (`id_medico`) REFERENCES `medicos` (`id_medico`),
  ADD CONSTRAINT `med_esp_ibfk_2` FOREIGN KEY (`id_esp`) REFERENCES `especialidades` (`id_esp`);

--
-- Limitadores para a tabela `prescricao`
--
ALTER TABLE `prescricao`
  ADD CONSTRAINT `prescricao_ibfk_1` FOREIGN KEY (`id_consulta`) REFERENCES `consultas` (`id_consulta`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
