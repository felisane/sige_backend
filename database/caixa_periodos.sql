CREATE TABLE IF NOT EXISTS `caixa_periodos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `abertura` datetime NOT NULL,
  `fechamento` datetime DEFAULT NULL,
  `usuario_abertura` varchar(100) NOT NULL,
  `usuario_fechamento` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
