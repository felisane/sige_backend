CREATE TABLE `categorias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `categorias` (`nome`) VALUES
('Categoria 1'),
('Categoria 2'),
('Categoria 3'),
('Categoria 4'),
('Categoria 5');
