-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 15-Jan-2019 às 23:38
-- Versão do servidor: 10.1.31-MariaDB
-- PHP Version: 7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `php_sir`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `administracao`
--

CREATE TABLE `administracao` (
  `idadmin` int(11) NOT NULL,
  `username` varchar(45) COLLATE utf8_bin NOT NULL,
  `password` varchar(100) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `administracao`
--

INSERT INTO `administracao` (`idadmin`, `username`, `password`) VALUES
(1, 'admin', '$10$uPTpuzyN6k9DkEFfNSiOvOy75BwJ.inVcstr2RMXrtTWGe5VDzn7K');

-- --------------------------------------------------------

--
-- Estrutura da tabela `grupo`
--

CREATE TABLE `grupo` (
  `idgrupo` int(11) NOT NULL,
  `nome` varchar(150) COLLATE utf8_bin NOT NULL,
  `descricao` varchar(1000) COLLATE utf8_bin NOT NULL,
  `fotografia` varchar(30) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `grupo`
--

INSERT INTO `grupo` (`idgrupo`, `nome`, `descricao`, `fotografia`) VALUES
(1, 'Familia', 'Grupo que reune todos os membros da nossa familia', 'default_image.png'),
(2, 'Amigos', 'Grupo que reune alguns dos amigos.', 'default_image.png');

-- --------------------------------------------------------

--
-- Estrutura da tabela `lista_contactos`
--

CREATE TABLE `lista_contactos` (
  `fk_idutilizador` int(11) NOT NULL,
  `fk_idutilizador_contacto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `lista_contactos`
--

INSERT INTO `lista_contactos` (`fk_idutilizador`, `fk_idutilizador_contacto`) VALUES
(24, 14),
(24, 13),
(24, 25);

-- --------------------------------------------------------

--
-- Estrutura da tabela `utilizador`
--

CREATE TABLE `utilizador` (
  `idutilizador` int(11) NOT NULL,
  `email` varchar(100) COLLATE utf8_bin NOT NULL,
  `password` varchar(100) COLLATE utf8_bin NOT NULL,
  `nome` varchar(200) COLLATE utf8_bin NOT NULL,
  `numero` int(11) NOT NULL,
  `fotografia` varchar(100) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `utilizador`
--

INSERT INTO `utilizador` (`idutilizador`, `email`, `password`, `nome`, `numero`, `fotografia`) VALUES
(13, 'leandro@ipvc.pt', '$2y$10$gaTV7AuFxNNivEZ5aKGsg.VcxInvbPU.cYjkE.jSb0fY49Z9J7y9O', 'Leandro Magalhães', 931245673, 'default_avatar.jpg'),
(14, 'joana@ipvc.pt', '$2y$10$tWYMoCwEkSZ/uSSGAfwnH.Q9WeiSpM6hDRhk8yFnIEhEwp.zg3JGC', 'Joana Araujo', 934521356, 'default_avatar.jpg'),
(23, 'maria@ipvc.pt', '$2y$10$CrtwUjvve5Hssf9806VVSOgqJBGd7x5H0alD0nvrXYBG/naW28Gp6', 'Maria Ines', 876543, '83281005de4f5ff36f57b39106c0212b.jpg'),
(24, 'mariana@ipvc.pt', '$2y$10$HXuzRZP8ONXKPhvF2mHne.mp5TejJg.AVAt5lZ4rz46ngGSawMSrK', 'Mariana Silva Pereira', 921456349, '66894e69060511f64d67059973f20252.jpg'),
(25, 'alexandra@ipvc.pt', '$2y$10$Fl72pkbt2ZL3VHF8xZJJJO10H1J9BJK74zrZirtMIGPePYTeEODoq', 'Alexandra Branco', 2147483647, 'bd0690d39398c10f7c16997577d25292.jpg');

-- --------------------------------------------------------

--
-- Estrutura da tabela `utilizador_grupo`
--

CREATE TABLE `utilizador_grupo` (
  `fk_idutilizador` int(11) NOT NULL,
  `fk_idgrupo` int(11) NOT NULL,
  `cargo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `utilizador_grupo`
--

INSERT INTO `utilizador_grupo` (`fk_idutilizador`, `fk_idgrupo`, `cargo`) VALUES
(14, 1, 1),
(24, 1, 3),
(13, 1, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administracao`
--
ALTER TABLE `administracao`
  ADD PRIMARY KEY (`idadmin`);

--
-- Indexes for table `grupo`
--
ALTER TABLE `grupo`
  ADD PRIMARY KEY (`idgrupo`);

--
-- Indexes for table `lista_contactos`
--
ALTER TABLE `lista_contactos`
  ADD KEY `fk_idutilizador_this_idx` (`fk_idutilizador`),
  ADD KEY `fk_idutilizador_contacto_idx` (`fk_idutilizador_contacto`);

--
-- Indexes for table `utilizador`
--
ALTER TABLE `utilizador`
  ADD PRIMARY KEY (`idutilizador`);

--
-- Indexes for table `utilizador_grupo`
--
ALTER TABLE `utilizador_grupo`
  ADD KEY `fk_contact_grupo_contacto_idx` (`fk_idutilizador`),
  ADD KEY `fk_contacto_grupo_grupo_idx` (`fk_idgrupo`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `administracao`
--
ALTER TABLE `administracao`
  MODIFY `idadmin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `grupo`
--
ALTER TABLE `grupo`
  MODIFY `idgrupo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `utilizador`
--
ALTER TABLE `utilizador`
  MODIFY `idutilizador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `lista_contactos`
--
ALTER TABLE `lista_contactos`
  ADD CONSTRAINT `fk_idutilizador_contacto` FOREIGN KEY (`fk_idutilizador_contacto`) REFERENCES `utilizador` (`idutilizador`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_idutilizador_this` FOREIGN KEY (`fk_idutilizador`) REFERENCES `utilizador` (`idutilizador`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `utilizador_grupo`
--
ALTER TABLE `utilizador_grupo`
  ADD CONSTRAINT `fk_contact_grupo_contacto` FOREIGN KEY (`fk_idutilizador`) REFERENCES `utilizador` (`idutilizador`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_contacto_grupo_grupo` FOREIGN KEY (`fk_idgrupo`) REFERENCES `grupo` (`idgrupo`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
