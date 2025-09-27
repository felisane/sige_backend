CREATE TABLE IF NOT EXISTS `caixa_periodos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `abertura` datetime NOT NULL,
  `fechamento` datetime DEFAULT NULL,
  `usuario_abertura` varchar(100) NOT NULL,
  `usuario_fechamento` varchar(100) DEFAULT NULL,
  `total_dinheiro` decimal(15,2) NOT NULL DEFAULT '0.00',
  `total_pos` decimal(15,2) NOT NULL DEFAULT '0.00',
  `total_transferencias` decimal(15,2) NOT NULL DEFAULT '0.00',
  `observacoes` text DEFAULT NULL,
  `confirmacao_responsavel` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
