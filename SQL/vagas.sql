-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 28-Nov-2023 às 14:46
-- Versão do servidor: 10.4.20-MariaDB
-- versão do PHP: 8.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `vagas`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `area`
--

CREATE TABLE `area` (
  `id_area` int(11) NOT NULL,
  `area` varchar(240) DEFAULT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `atuacao`
--

CREATE TABLE `atuacao` (
  `id_atuacao` int(11) NOT NULL,
  `atuacao` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `atuacao`
--

INSERT INTO `atuacao` (`id_atuacao`, `atuacao`) VALUES
(1, 'Presencial'),
(2, 'Remoto'),
(3, 'Híbrido');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipo`
--

CREATE TABLE `tipo` (
  `id_tipo` int(11) NOT NULL,
  `tipo` varchar(240) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `tipo`
--

INSERT INTO `tipo` (`id_tipo`, `tipo`) VALUES
(1, 'Estágio'),
(2, 'CLT'),
(3, 'PJ');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `email` varchar(45) DEFAULT NULL,
  `senha` varchar(45) DEFAULT NULL,
  `img_usuario` varchar(255) DEFAULT NULL,
  `pin` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `vaga`
--

CREATE TABLE `vaga` (
  `id_vaga` int(11) NOT NULL,
  `vaga` varchar(100) DEFAULT NULL,
  `desc_vaga` varchar(1000) DEFAULT NULL,
  `hora_vaga` int(11) DEFAULT NULL,
  `per_vaga` varchar(20) DEFAULT NULL,
  `sal_vaga` float(10,2) DEFAULT NULL,
  `emp_vaga` varchar(240) DEFAULT NULL,
  `img_vaga` varchar(255) DEFAULT NULL,
  `id_tipo` int(11) NOT NULL,
  `id_atuacao` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `vaga_area`
--

CREATE TABLE `vaga_area` (
  `id_vaga` int(11) NOT NULL,
  `id_area` int(11) NOT NULL,
  `ordem_area` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `area`
--
ALTER TABLE `area`
  ADD PRIMARY KEY (`id_area`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Índices para tabela `atuacao`
--
ALTER TABLE `atuacao`
  ADD PRIMARY KEY (`id_atuacao`);

--
-- Índices para tabela `tipo`
--
ALTER TABLE `tipo`
  ADD PRIMARY KEY (`id_tipo`);

--
-- Índices para tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`);

--
-- Índices para tabela `vaga`
--
ALTER TABLE `vaga`
  ADD PRIMARY KEY (`id_vaga`),
  ADD KEY `id_tipo` (`id_tipo`),
  ADD KEY `id_atuacao` (`id_atuacao`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Índices para tabela `vaga_area`
--
ALTER TABLE `vaga_area`
  ADD KEY `id_vaga` (`id_vaga`),
  ADD KEY `id_area` (`id_area`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `area`
--
ALTER TABLE `area`
  MODIFY `id_area` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de tabela `atuacao`
--
ALTER TABLE `atuacao`
  MODIFY `id_atuacao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `tipo`
--
ALTER TABLE `tipo`
  MODIFY `id_tipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `vaga`
--
ALTER TABLE `vaga`
  MODIFY `id_vaga` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `area`
--
ALTER TABLE `area`
  ADD CONSTRAINT `area_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Limitadores para a tabela `vaga`
--
ALTER TABLE `vaga`
  ADD CONSTRAINT `vaga_ibfk_1` FOREIGN KEY (`id_tipo`) REFERENCES `tipo` (`id_tipo`),
  ADD CONSTRAINT `vaga_ibfk_2` FOREIGN KEY (`id_atuacao`) REFERENCES `atuacao` (`id_atuacao`),
  ADD CONSTRAINT `vaga_ibfk_3` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Limitadores para a tabela `vaga_area`
--
ALTER TABLE `vaga_area`
  ADD CONSTRAINT `vaga_area_ibfk_1` FOREIGN KEY (`id_vaga`) REFERENCES `vaga` (`id_vaga`),
  ADD CONSTRAINT `vaga_area_ibfk_2` FOREIGN KEY (`id_area`) REFERENCES `area` (`id_area`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
