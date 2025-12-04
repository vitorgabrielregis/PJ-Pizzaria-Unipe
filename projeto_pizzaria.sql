-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 03/12/2025 às 16:54
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
-- Banco de dados: `projeto_pizzaria`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `itens_pedido`
--

CREATE TABLE `itens_pedido` (
  `id` int(11) NOT NULL,
  `pedido_id` int(11) DEFAULT NULL,
  `pizza_id` int(11) DEFAULT NULL,
  `quantidade` int(11) NOT NULL,
  `preco_unitario` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `nome_cliente` varchar(100) NOT NULL,
  `endereco_entrega` varchar(255) NOT NULL,
  `total_pedido` decimal(10,2) NOT NULL,
  `data_pedido` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `pizzas`
--

CREATE TABLE `pizzas` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `descricao` text DEFAULT NULL,
  `preco` decimal(10,2) NOT NULL,
  `categoria` varchar(50) NOT NULL,
  `imagem` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `pizzas`
--

INSERT INTO `pizzas` (`id`, `nome`, `descricao`, `preco`, `categoria`, `imagem`) VALUES
(1, 'Margherita', 'Molho de tomate, mussarela e manjericão fresco', 28.00, 'Tradicional', 'margherita_1764772872.jpg'),
(2, 'Calabresa', 'Calabresa fatiada com cebola e orégano', 30.00, 'Tradicional', 'calabresa_1764772863.jpg'),
(3, 'Frango com Catupiry', 'Frango desfiado com catupiry cremoso', 32.00, 'Especial', 'frango_1764772848.jpg'),
(4, 'Quatro Queijos', 'Mussarela, parmesão, provolone e gorgonzola', 35.00, 'Especial', 'quatroqueijos_1764772836.jpg'),
(5, 'Portuguesa', 'Presunto, ovo, cebola, pimentão e azeitonas', 33.00, 'Tradicional', 'Portuguesa_1764772822.jpg'),
(6, 'Vegana', 'Queijo vegano, tomate, manjericão e azeite', 29.00, 'tradicional', 'Vegana_1764772814.jpg'),
(7, 'Pizza Pudim', 'Pudim', 40.00, 'especial', 'Pizza_pudim_1764772550.jpg'),
(8, 'Lombo Canadense', 'Lombo defumado e coberto por muçarela ou Catupiry.', 45.00, 'Especial', 'Lombo_canadense_1764774408.jpg');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `tipo` enum('cliente','admin') NOT NULL DEFAULT 'cliente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `senha`, `tipo`) VALUES
(6, 'Davi', '$2b$12$vlw9sAhXK.in78vJmLvFo.1mreSL1zfpP1tSx8sIAXiTbkgAtn3WK', 'admin'),
(7, 'Vitor Gabriel', '$2b$12$VnAv6mo9MIYglK9kBEGfo.zS7RSsRytANiH0975SJgZHESt6zxnxm', 'admin'),
(8, 'Erick Mauricio', '$2b$12$iMyGqb21oHOu/8mYOrQPYe89J0MoIfsvFE34rh21KnaMe3IUzLIZi', 'admin'),
(9, 'TR014777', '$2b$12$bgpeJtJ3aNbGKjPPX1nDDe1WnHHadDSX.M/AEFJp9nwwL/ipUaWfW', 'admin');
(10, 'admin', '$2y$10$X6vCa1kMSsB6AUK9WVyAWuLUUNWWTs2rDQk9V7mKSlI1rKLy28EM6', 'admin');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `itens_pedido`
--
ALTER TABLE `itens_pedido`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pedido_id` (`pedido_id`),
  ADD KEY `pizza_id` (`pizza_id`);

--
-- Índices de tabela `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `pizzas`
--
ALTER TABLE `pizzas`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario` (`usuario`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `itens_pedido`
--
ALTER TABLE `itens_pedido`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `pizzas`
--
ALTER TABLE `pizzas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `itens_pedido`
--
ALTER TABLE `itens_pedido`
  ADD CONSTRAINT `itens_pedido_ibfk_1` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`),
  ADD CONSTRAINT `itens_pedido_ibfk_2` FOREIGN KEY (`pizza_id`) REFERENCES `pizzas` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
