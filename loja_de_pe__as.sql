-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 02/12/2025 às 02:34
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `loja_de_peças`
--

DELIMITER $$
--
-- Procedimentos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `inserir_produtos_massivos` (IN `quantidade` INT)   BEGIN
    DECLARE i INT DEFAULT 1;

    WHILE i <= quantidade DO
        INSERT INTO Produto (nome, preco, img)
        VALUES (
            CONCAT('Produto ', i),       -- Nome sequencial
            ROUND(RAND() * 1000, 2),    -- Preço aleatório entre 0 e 1000
            CONCAT('https://picsum.photos/200/200?random=', i) -- Imagem de exemplo
        );
        SET i = i + 1;
    END WHILE;
END$$

--
-- Funções
--
CREATE DEFINER=`root`@`localhost` FUNCTION `verificar_estoque` (`p_produto_id` INT, `p_filial_id` INT, `p_quantidade_desejada` INT) RETURNS TINYINT(1) DETERMINISTIC BEGIN
    DECLARE estoque_atual INT;

    -- Busca a quantidade disponível no estoque
    SELECT quantidade 
    INTO estoque_atual
    FROM estoque
    WHERE produto_id = p_produto_id
      AND filial_id = p_filial_id
    LIMIT 1;

    -- Se não encontrar registro, considera estoque 0
    IF estoque_atual IS NULL THEN
        SET estoque_atual = 0;
    END IF;

    -- Verifica se há estoque suficiente
    IF estoque_atual >= p_quantidade_desejada THEN
        RETURN TRUE;
    ELSE
        RETURN FALSE;
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `verificar_estoque_filial` (`p_produto_id` INT, `p_filial_id` INT, `p_quantidade_desejada` INT) RETURNS TINYINT(1) DETERMINISTIC BEGIN
    DECLARE estoque_atual INT;

     SELECT quantidade 
    INTO estoque_atual
    FROM estoque_filial
    WHERE produto_id = p_produto_id
      AND filial_id = p_filial_id
    LIMIT 1;

     IF estoque_atual IS NULL THEN
        SET estoque_atual = 0;
    END IF;

     IF estoque_atual >= p_quantidade_desejada THEN
        RETURN TRUE;
    ELSE
        RETURN FALSE;
    END IF;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `auditoria_produto`
--

CREATE TABLE `auditoria_produto` (
  `id_auditoria` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `valor_antigo` decimal(10,2) NOT NULL,
  `valor_novo` decimal(10,2) NOT NULL,
  `data_alteracao` datetime NOT NULL DEFAULT current_timestamp(),
  `usuario` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `contato`
--

CREATE TABLE `contato` (
  `id_contado` int(11) NOT NULL,
  `pessoa_id` int(11) NOT NULL,
  `telefone` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `endereco`
--

CREATE TABLE `endereco` (
  `id_endereco` int(11) NOT NULL,
  `dono_id` int(11) NOT NULL,
  `CEP` varchar(9) NOT NULL,
  `Nome_Rua` varchar(55) NOT NULL,
  `Municipio` varchar(55) NOT NULL,
  `Numero` int(11) NOT NULL,
  `Bairro` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `estoque_filial`
--

CREATE TABLE `estoque_filial` (
  `id_estoque` int(11) NOT NULL,
  `produto_id` int(11) NOT NULL,
  `filial_id` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `estoque_filial`
--

INSERT INTO `estoque_filial` (`id_estoque`, `produto_id`, `filial_id`, `quantidade`) VALUES
(1, 2, 1, 1500),
(2, 5, 2, 5);

-- --------------------------------------------------------

--
-- Estrutura para tabela `filial`
--

CREATE TABLE `filial` (
  `id_filial` int(11) NOT NULL,
  `nome_filial` varchar(100) NOT NULL,
  `UF` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `filial`
--

INSERT INTO `filial` (`id_filial`, `nome_filial`, `UF`) VALUES
(1, 'Loja Campo Mourão', 'PR'),
(2, 'Ipuaçu', 'SC'),
(3, 'Uruguaiana', 'RS');

-- --------------------------------------------------------

--
-- Estrutura para tabela `icms_prod_filial`
--

CREATE TABLE `icms_prod_filial` (
  `id_icms` int(11) NOT NULL,
  `produto_id` int(11) NOT NULL,
  `filial_id` int(11) NOT NULL,
  `valor` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `icms_prod_filial`
--

INSERT INTO `icms_prod_filial` (`id_icms`, `produto_id`, `filial_id`, `valor`) VALUES
(1, 2, 1, 15.5),
(2, 5, 1, 22),
(3, 4, 3, 11.8),
(3, 7, 3, 11);

-- --------------------------------------------------------

--
-- Estrutura para tabela `operador`
--

CREATE TABLE `operador` (
  `codigo_operador` int(11) NOT NULL,
  `pessoa_id` int(11) NOT NULL,
  `senha` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `operador`
--

INSERT INTO `operador` (`codigo_operador`, `pessoa_id`, `senha`) VALUES
(1, 1, '123');

-- --------------------------------------------------------

--
-- Estrutura para tabela `pessoa`
--

CREATE TABLE `pessoa` (
  `id_pessoa` int(11) NOT NULL,
  `nome` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `pessoa`
--

INSERT INTO `pessoa` (`id_pessoa`, `nome`) VALUES
(1, 'Gabriel Teste'),
(6, 'joao'),
(7, 'joao'),
(8, 'Messi'),
(9, 'teste'),
(10, 'teste 2'),
(11, 'teste 2'),
(12, 'Gabriel Carlos Balastrelli gabriel'),
(14, 'Ronaldo Fenomeno gordo');

-- --------------------------------------------------------

--
-- Estrutura para tabela `pessoa_fisica`
--

CREATE TABLE `pessoa_fisica` (
  `pessoa_id` int(11) NOT NULL,
  `cpf` varchar(14) NOT NULL,
  `rg` int(11) NOT NULL,
  `data_nascimento` date NOT NULL,
  `estado_civil` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `pessoa_fisica`
--

INSERT INTO `pessoa_fisica` (`pessoa_id`, `cpf`, `rg`, `data_nascimento`, `estado_civil`) VALUES
(14, '000000000000', 2147483647, '0000-00-00', '0000-00-00');

-- --------------------------------------------------------

--
-- Estrutura para tabela `pessoa_juridica`
--

CREATE TABLE `pessoa_juridica` (
  `pessoa_id` int(11) NOT NULL,
  `CNPJ` varchar(14) NOT NULL,
  `Data_Fundacao` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `produto`
--

CREATE TABLE `produto` (
  `id_produto` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `preco` float NOT NULL,
  `img` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `produto`
--

INSERT INTO `produto` (`id_produto`, `nome`, `preco`, `img`) VALUES
(2, 'Dois Pneu', 500, 'https://images.tcdn.com.br/img/img_prod/478291/combo_2_pneus_trator_agricola_agrale_rural_750_16_frontiera_8l_maggion_47661_1_20191216113729.jpg'),
(4, 'oleo motor maquina cortar grama', 233, 'https://i.redd.it/993ii82srbcd1.jpeg'),
(5, 'Motor ', 650000, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQJuPWWivIjdRfZ8cemdbnc4D0NMankbfP0JQ&s'),
(6, 'Produto 1', 527.01, 'https://picsum.photos/200/200?random=1'),
(7, 'Produto 2', 415.32, 'https://picsum.photos/200/200?random=2'),
(8, 'Produto 3', 495.54, 'https://picsum.photos/200/200?random=3'),
(9, 'Produto 4', 231.77, 'https://picsum.photos/200/200?random=4'),
(10, 'Produto 5', 672.21, 'https://picsum.photos/200/200?random=5'),
(11, 'Produto 6', 665.77, 'https://picsum.photos/200/200?random=6'),
(12, 'Produto 7', 312.18, 'https://picsum.photos/200/200?random=7'),
(13, 'Produto 8', 563.62, 'https://picsum.photos/200/200?random=8'),
(14, 'Produto 9', 881.55, 'https://picsum.photos/200/200?random=9'),
(15, 'Produto 10', 716.87, 'https://picsum.photos/200/200?random=10'),
(16, 'Produto 11', 939.71, 'https://picsum.photos/200/200?random=11'),
(17, 'Produto 12', 547.95, 'https://picsum.photos/200/200?random=12'),
(18, 'Produto 13', 920.62, 'https://picsum.photos/200/200?random=13'),
(19, 'Produto 14', 959.24, 'https://picsum.photos/200/200?random=14'),
(20, 'Produto 15', 34.32, 'https://picsum.photos/200/200?random=15'),
(21, 'Produto 16', 293.91, 'https://picsum.photos/200/200?random=16'),
(22, 'Produto 17', 366.59, 'https://picsum.photos/200/200?random=17'),
(23, 'Produto 18', 951.2, 'https://picsum.photos/200/200?random=18'),
(24, 'Produto 19', 656.24, 'https://picsum.photos/200/200?random=19'),
(25, 'Produto 20', 427.61, 'https://picsum.photos/200/200?random=20'),
(26, 'Produto 21', 169.33, 'https://picsum.photos/200/200?random=21'),
(27, 'Produto 22', 563.8, 'https://picsum.photos/200/200?random=22'),
(28, 'Produto 23', 311.04, 'https://picsum.photos/200/200?random=23'),
(29, 'Produto 24', 863.79, 'https://picsum.photos/200/200?random=24'),
(30, 'Produto 25', 385.84, 'https://picsum.photos/200/200?random=25'),
(31, 'Produto 26', 337.84, 'https://picsum.photos/200/200?random=26'),
(32, 'Produto 27', 531.65, 'https://picsum.photos/200/200?random=27'),
(33, 'Produto 28', 644.74, 'https://picsum.photos/200/200?random=28'),
(34, 'Produto 29', 628.76, 'https://picsum.photos/200/200?random=29'),
(35, 'Produto 30', 209.59, 'https://picsum.photos/200/200?random=30'),
(36, 'Produto 31', 161.66, 'https://picsum.photos/200/200?random=31'),
(37, 'Produto 32', 179.51, 'https://picsum.photos/200/200?random=32'),
(38, 'Produto 33', 412.59, 'https://picsum.photos/200/200?random=33'),
(39, 'Produto 34', 524.43, 'https://picsum.photos/200/200?random=34'),
(40, 'Produto 35', 384.38, 'https://picsum.photos/200/200?random=35'),
(41, 'Produto 36', 348.59, 'https://picsum.photos/200/200?random=36'),
(42, 'Produto 37', 589.84, 'https://picsum.photos/200/200?random=37'),
(43, 'Produto 38', 903.4, 'https://picsum.photos/200/200?random=38'),
(44, 'Produto 39', 747.5, 'https://picsum.photos/200/200?random=39'),
(45, 'Produto 40', 27.31, 'https://picsum.photos/200/200?random=40'),
(46, 'Produto 41', 894.04, 'https://picsum.photos/200/200?random=41'),
(47, 'Produto 42', 388.25, 'https://picsum.photos/200/200?random=42'),
(48, 'Produto 43', 259.13, 'https://picsum.photos/200/200?random=43'),
(49, 'Produto 44', 130.93, 'https://picsum.photos/200/200?random=44'),
(50, 'Produto 45', 877.24, 'https://picsum.photos/200/200?random=45'),
(51, 'Produto 46', 993.41, 'https://picsum.photos/200/200?random=46'),
(52, 'Produto 47', 335.35, 'https://picsum.photos/200/200?random=47'),
(53, 'Produto 48', 696.49, 'https://picsum.photos/200/200?random=48'),
(54, 'Produto 49', 476.42, 'https://picsum.photos/200/200?random=49'),
(55, 'Produto 50', 292.62, 'https://picsum.photos/200/200?random=50');

--
-- Acionadores `produto`
--
DELIMITER $$
CREATE TRIGGER `trigger_auditoria_produto` BEFORE UPDATE ON `produto` FOR EACH ROW BEGIN
    -- Só registra se o valor realmente mudou
    IF OLD.preco <> NEW.preco THEN
        INSERT INTO auditoria_produto (id_produto, valor_antigo, valor_novo)
        VALUES (OLD.id_produto, OLD.preco, NEW.preco);
    END IF;
END
$$
DELIMITER ;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `auditoria_produto`
--
ALTER TABLE `auditoria_produto`
  ADD PRIMARY KEY (`id_auditoria`);

--
-- Índices de tabela `contato`
--
ALTER TABLE `contato`
  ADD PRIMARY KEY (`id_contado`,`pessoa_id`);

--
-- Índices de tabela `endereco`
--
ALTER TABLE `endereco`
  ADD PRIMARY KEY (`id_endereco`,`dono_id`),
  ADD KEY `dono_id` (`dono_id`) USING BTREE;

--
-- Índices de tabela `estoque_filial`
--
ALTER TABLE `estoque_filial`
  ADD PRIMARY KEY (`id_estoque`,`produto_id`,`filial_id`),
  ADD KEY `fk_id_filial` (`filial_id`),
  ADD KEY `fk_id_produto` (`produto_id`);

--
-- Índices de tabela `filial`
--
ALTER TABLE `filial`
  ADD PRIMARY KEY (`id_filial`);

--
-- Índices de tabela `icms_prod_filial`
--
ALTER TABLE `icms_prod_filial`
  ADD PRIMARY KEY (`id_icms`,`produto_id`,`filial_id`),
  ADD KEY `fk_produto` (`produto_id`),
  ADD KEY `fk_filial` (`filial_id`);

--
-- Índices de tabela `operador`
--
ALTER TABLE `operador`
  ADD PRIMARY KEY (`codigo_operador`,`pessoa_id`),
  ADD KEY `fk_pessoa` (`pessoa_id`);

--
-- Índices de tabela `pessoa`
--
ALTER TABLE `pessoa`
  ADD PRIMARY KEY (`id_pessoa`);

--
-- Índices de tabela `pessoa_fisica`
--
ALTER TABLE `pessoa_fisica`
  ADD PRIMARY KEY (`pessoa_id`);

--
-- Índices de tabela `pessoa_juridica`
--
ALTER TABLE `pessoa_juridica`
  ADD PRIMARY KEY (`pessoa_id`);

--
-- Índices de tabela `produto`
--
ALTER TABLE `produto`
  ADD PRIMARY KEY (`id_produto`),
  ADD KEY `id_produto` (`id_produto`),
  ADD KEY `idx_produto_nome` (`nome`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `auditoria_produto`
--
ALTER TABLE `auditoria_produto`
  MODIFY `id_auditoria` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `operador`
--
ALTER TABLE `operador`
  MODIFY `codigo_operador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `pessoa`
--
ALTER TABLE `pessoa`
  MODIFY `id_pessoa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de tabela `produto`
--
ALTER TABLE `produto`
  MODIFY `id_produto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `estoque_filial`
--
ALTER TABLE `estoque_filial`
  ADD CONSTRAINT `fk_id_filial` FOREIGN KEY (`filial_id`) REFERENCES `filial` (`id_filial`),
  ADD CONSTRAINT `fk_id_produto` FOREIGN KEY (`produto_id`) REFERENCES `produto` (`id_produto`);

--
-- Restrições para tabelas `icms_prod_filial`
--
ALTER TABLE `icms_prod_filial`
  ADD CONSTRAINT `fk_filial` FOREIGN KEY (`filial_id`) REFERENCES `filial` (`id_filial`),
  ADD CONSTRAINT `fk_produto` FOREIGN KEY (`produto_id`) REFERENCES `produto` (`id_produto`);

--
-- Restrições para tabelas `operador`
--
ALTER TABLE `operador`
  ADD CONSTRAINT `fk_pessoa` FOREIGN KEY (`pessoa_id`) REFERENCES `pessoa` (`id_pessoa`);

--
-- Restrições para tabelas `pessoa_juridica`
--
ALTER TABLE `pessoa_juridica`
  ADD CONSTRAINT `fk_id_pessoa` FOREIGN KEY (`pessoa_id`) REFERENCES `pessoa` (`id_pessoa`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
