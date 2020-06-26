CREATE SCHEMA IF NOT EXISTS `loja-virtual` DEFAULT CHARACTER SET utf8 ;

CREATE TABLE `loja-virtual`.`grupos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuarios_id` int(11) DEFAULT NULL,
  `nome` varchar(100) NOT NULL,
  `gdc` tinyint(4) DEFAULT NULL,
  `data_cadastro` datetime DEFAULT NULL,
  `data_alteracao` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
);

INSERT INTO `loja-virtual`.`grupos` VALUES (1,NULL,'Administradores Master',0,NULL,NULL),(2,NULL,'Modulo de grupos',NULL,NULL,NULL);

CREATE TABLE `loja-virtual`.`categorias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(150) NOT NULL,
  `imagem` varchar(150) DEFAULT NULL,
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
);

INSERT INTO `loja-virtual`.`categorias` VALUES 
(1,'Celulares','/public/image/categorias/celulares.jpg',1),
(2,'Tablets','/public/image/categorias/tablets.jpg',2),
(3,'Notebooks','/public/image/categorias/notebooks.jpg',3),
(4,'Desktops','/public/image/categorias/desktops.jpg',4),
(5,'Informatica','/public/image/categorias/informatica.jpg',5);

CREATE TABLE `loja-virtual`.`usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(150) NOT NULL,
  `cpf` varchar(14) NOT NULL,
  `email` varchar(150) NOT NULL,
  `senha` varchar(60) DEFAULT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `celular` varchar(20) DEFAULT NULL,
  `foto` varchar(150) DEFAULT NULL,
  `data_cadastro` datetime DEFAULT NULL,
  `data_alteracao` datetime DEFAULT NULL,
  `ativo` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
);

INSERT INTO `loja-virtual`.`usuarios` VALUES 
(1,'Admininistrador','10424522020','admin@exemplo.com','$2y$12$vK4LgSYsctGjn64XnD2oVuucfOtAESYNAyt96ey.czrG4afQim7Oi','','(11) 91111-1111','/public/image/perfil/1.jpg','2018-07-26 17:03:41','2020-06-26 05:47:14',1);

CREATE TABLE `loja-virtual`.`endereco` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuarios_id` int(11) NOT NULL,
  `cep` varchar(20) DEFAULT NULL,
  `lagradouro` varchar(100) DEFAULT NULL,
  `numero` int(11) DEFAULT NULL,
  `complemento` varchar(45) DEFAULT NULL,
  `bairro` varchar(100) DEFAULT NULL,
  `cidade` varchar(100) DEFAULT NULL,
  `estado` varchar(100) DEFAULT NULL,
  `pais` varchar(100) DEFAULT NULL,
  `data_cadastro` datetime DEFAULT NULL,
  `data_alteracao` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
);

INSERT INTO `loja-virtual`.`endereco` VALUES (1,1,'06717-335','Rua Surucuá',0,'','','Cotia','SP','Brasil','2020-06-24 01:09:28',NULL);

CREATE TABLE `loja-virtual`.`sessions` (
  `id` varchar(32) NOT NULL,
  `expires` datetime NOT NULL,
  `datas` text,
  `usuarios_id` int(11) DEFAULT NULL,
  `nome` varchar(150) DEFAULT NULL,
  `ip` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `loja-virtual`.`niveis` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `nivel` varchar(30) DEFAULT NULL,
  `descricao` text,
  PRIMARY KEY (`id`)
);

INSERT INTO `loja-virtual`.`niveis` VALUES 
(1,'Participante','Usuário do sistema'),
(2,'Administrador','Administrador do sistema');


CREATE TABLE `loja-virtual`.`pedidos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
);

INSERT INTO `loja-virtual`.`pedidos` VALUES 
(3,1,1),
(4,1,1),
(5,1,1);

CREATE TABLE `loja-virtual`.`produtos` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `nome` varchar(120) NOT NULL,
  `descricao` text NOT NULL,
  `marca` varchar(100) NOT NULL,
  `preco` decimal(8,2) NOT NULL,
  `ram` int(11) NOT NULL,
  `armazenamento` int(11) NOT NULL,
  `camera` varchar(20) NOT NULL,
  `imagem` varchar(100) NOT NULL,
  `quantidade` mediumint(5) NOT NULL,
  `status` tinyint(4) NOT NULL COMMENT '0-active,1-inactive',
  PRIMARY KEY (`id`)
);

INSERT INTO `loja-virtual`.`produtos` VALUES 
(1,'Honor 9 Lite (Sapphire Blue, 64 GB)  (4 GB RAM)','Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quidem debitis enim facilis porro quia in voluptates praesentium, cupiditate, dolorum. Facilis minus, quidem! Id perspiciatis labore praesentium voluptatibus assumenda odio, magni.','Honor',14499.00,4,64,'13','/public/image/shop/honor.jpg',10,1),
(2,'Infinix Hot S3 (Sandstone Black, 32 GB)  (3 GB RAM)','Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quidem debitis enim facilis porro quia in voluptates praesentium, cupiditate, dolorum. Facilis minus, quidem! Id perspiciatis labore praesentium voluptatibus assumenda odio, magni.','Infinix',8999.00,3,32,'13','/public/image/shop/infinit.jpg',10,1),
(3,'VIVO V9 Youth (Gold, 32 GB)  (4 GB RAM)','Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quidem debitis enim facilis porro quia in voluptates praesentium, cupiditate, dolorum. Facilis minus, quidem! Id perspiciatis labore praesentium voluptatibus assumenda odio, magni.','VIVO',16990.00,4,32,'16','/public/image/shop/vivo.jpg',10,1),
(4,'Moto E4 Plus (Fine Gold, 32 GB)  (3 GB RAM)','Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quidem debitis enim facilis porro quia in voluptates praesentium, cupiditate, dolorum. Facilis minus, quidem! Id perspiciatis labore praesentium voluptatibus assumenda odio, magni.','Motorola',11499.00,3,32,'8','/public/image/shop/motorola.jpg',10,1),
(5,'Lenovo K8 Plus (Venom Black, 32 GB)  (3 GB RAM)','Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quidem debitis enim facilis porro quia in voluptates praesentium, cupiditate, dolorum. Facilis minus, quidem! Id perspiciatis labore praesentium voluptatibus assumenda odio, magni.','Lenevo',9999.00,3,32,'13','/public/image/shop/lenovo.jpg',10,1),
(6,'Samsung Galaxy On Nxt (Gold, 16 GB)  (3 GB RAM)','Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quidem debitis enim facilis porro quia in voluptates praesentium, cupiditate, dolorum. Facilis minus, quidem! Id perspiciatis labore praesentium voluptatibus assumenda odio, magni.','Samsung',10990.00,3,16,'13','/public/image/shop/sansung.jpg',10,1),
(7,'Moto C Plus (Pearl White, 16 GB)  (2 GB RAM)','Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quidem debitis enim facilis porro quia in voluptates praesentium, cupiditate, dolorum. Facilis minus, quidem! Id perspiciatis labore praesentium voluptatibus assumenda odio, magni.','Motorola',7799.00,2,16,'8','/public/image/shop/vivo.jpg',10,1),
(8,'Panasonic P77 (White, 16 GB)  (1 GB RAM)','Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quidem debitis enim facilis porro quia in voluptates praesentium, cupiditate, dolorum. Facilis minus, quidem! Id perspiciatis labore praesentium voluptatibus assumenda odio, magni.','Panasonic',5999.00,1,16,'8','/public/image/shop/lenovo.jpg',10,1),
(9,'OPPO F5 (Black, 64 GB)  (6 GB RAM)','Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quidem debitis enim facilis porro quia in voluptates praesentium, cupiditate, dolorum. Facilis minus, quidem! Id perspiciatis labore praesentium voluptatibus assumenda odio, magni.','OPPO',19990.00,6,64,'16','/public/image/shop/asus.jpg',10,1),
(10,'Honor 7A (Gold, 32 GB)  (3 GB RAM)','Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quidem debitis enim facilis porro quia in voluptates praesentium, cupiditate, dolorum. Facilis minus, quidem! Id perspiciatis labore praesentium voluptatibus assumenda odio, magni.','Honor',8999.00,3,32,'13','/public/image/shop/xiami.jpg',10,1),
(11,'Asus ZenFone 5Z (Midnight Blue, 64 GB)  (6 GB RAM)','Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quidem debitis enim facilis porro quia in voluptates praesentium, cupiditate, dolorum. Facilis minus, quidem! Id perspiciatis labore praesentium voluptatibus assumenda odio, magni.','Asus',29999.00,6,128,'12','/public/image/shop/google.jpg',10,1),
(12,'Redmi 5A (Gold, 32 GB)  (3 GB RAM)','Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quidem debitis enim facilis porro quia in voluptates praesentium, cupiditate, dolorum. Facilis minus, quidem! Id perspiciatis labore praesentium voluptatibus assumenda odio, magni.','MI',5999.00,3,32,'13','/public/image/shop/xiami.jpg',10,1),
(13,'Intex Indie 5 (Black, 16 GB)  (2 GB RAM)','Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quidem debitis enim facilis porro quia in voluptates praesentium, cupiditate, dolorum. Facilis minus, quidem! Id perspiciatis labore praesentium voluptatibus assumenda odio, magni.','Intex',4999.00,2,16,'8','/public/image/shop/google.jpg',10,1),
(14,'Google Pixel 2 XL (18:9 Display, 64 GB) White','Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quidem debitis enim facilis porro quia in voluptates praesentium, cupiditate, dolorum. Facilis minus, quidem! Id perspiciatis labore praesentium voluptatibus assumenda odio, magni.','Google',61990.00,4,64,'12','/public/image/shop/iphone.jpg',10,1);

CREATE TABLE `loja-virtual`.`pedidos_produtos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `produto_id` int(11) NOT NULL,
  `pedido_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
);

INSERT INTO `loja-virtual`.`pedidos_produtos` VALUES 
(1,1,3),
(2,2,3),
(3,1,4),
(4,2,4),
(5,1,5);

CREATE TABLE `loja-virtual`.`categorias_produtos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categoria_id` int(11) NOT NULL,
  `produto_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
);

INSERT INTO `loja-virtual`.`categorias_produtos` VALUES (1,1,1),(2,1,2),(3,1,3),(4,1,4),(5,1,5),(6,1,6),(7,1,7),(8,1,8),(9,1,9),(10,1,10),(11,1,11),(12,1,12),(13,1,13),(14,1,14),(15,5,1),(16,5,2),(17,5,3),(18,5,4),(19,5,5);

CREATE TABLE `loja-virtual`.`recuperar_senha` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuarios_id` int(11) NOT NULL,
  `token` varchar(32) NOT NULL,
  `data_cadastro` datetime NOT NULL,
  `data_alteracao` datetime DEFAULT NULL,
  `ativo` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `loja-virtual`.`grupos_usuarios_niveis` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuarios_id` int(11) NOT NULL,
  `grupos_id` int(11) NOT NULL,
  `niveis_id` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
);

INSERT INTO `loja-virtual`.`grupos_usuarios_niveis` VALUES (1,1,1,2);