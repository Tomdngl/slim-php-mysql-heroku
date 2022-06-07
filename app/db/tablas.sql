--Creacion de la tabla tipoEmpleado
CREATE TABLE `Hi5USsV2ss`.`tipoEmpleado` 
( `codTipoEmpleado` INT(2) NOT NULL ,
 `categoria` VARCHAR(255) NOT NULL , 
 PRIMARY KEY (`codTipoEmpleado`)) 
 ENGINE = InnoDB;
 ALTER TABLE `tipoEmpleado` ADD UNIQUE(`codTipoEmpleado`);
 --Añado tipos de empleados a la tabla tipoEmpleado
 INSERT INTO `tipoEmpleado` (`codTipoEmpleado`, `categoria`) VALUES
(1, 'Bartender'),
(2, 'Cervezero'),
(3, 'Cocinero'),
(4, 'Mozo'),
(5, 'Socio');
--Creacion de la tabla tipoProducto
CREATE TABLE `Hi5USsV2ss`.`tipoProducto` 
( `codTipoProducto` INT(2) NOT NULL ,
 `categoria` VARCHAR(255) NOT NULL ,
  PRIMARY KEY (`codTipoProducto`)) 
  ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_unicode_ci;
--
   ALTER TABLE `tipoProducto` ADD UNIQUE(`codTipoProducto`);
--Añado tipo de productos a la tabla tipoProducto
 INSERT INTO `tipoProducto` (`codTipoProducto`, `categoria`) VALUES
(1, 'Tragos y vinos'),
(2, 'Cerveza'),
(3, 'Comidas y bebidas'),
(4, 'Postres')
--Creacion de la tabla estadoMesa
CREATE TABLE `Hi5USsV2ss`.`estadoMesa` 
( `codEstadoMesa` INT(2) NOT NULL ,
 `descripcion` VARCHAR(255) NOT NULL , 
 PRIMARY KEY (`codEstadoMesa`))
  ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_unicode_ci;
--Añado estado de mesas a la tabla estadoMesa
 INSERT INTO `estadoMesa` (`codEstadoMesa`, `descripcion`) VALUES
(1, 'con cliente esperando pedido'),
(2, 'con cliente comiendo'),
(3, 'con cliente pagando'),
(4, 'cerrada')
--Creacion de la tabla clientes
CREATE TABLE `Hi5USsV2ss`.`clientes` 
( `id` INT(11) NOT NULL AUTO_INCREMENT , 
`usuario` VARCHAR(255) NOT NULL , 
`clave` VARCHAR(255) NOT NULL , 
`nombre` VARCHAR(255) NOT NULL , 
`apellido` VARCHAR(255) NOT NULL ,  
`fechaBaja` DATE NULL DEFAULT NULL , 
PRIMARY KEY (`id`))
 ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_unicode_ci;
--Creacion de la tabla mesas
CREATE TABLE `Hi5USsV2ss`.`mesas` 
( `id` VARCHAR(5) NOT NULL ,
 `estadoMesa` INT(2) NOT NULL ,
  `fechaBaja` DATE NULL DEFAULT NULL ,
   UNIQUE (`id`)) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_unicode_ci;
--Agrego clave foranea
ALTER TABLE mesas ADD FOREIGN KEY (estadoMesa) REFERENCES estadoMesa(codEstadoMesa)
--Creacion de la tabla productos
CREATE TABLE `Hi5USsV2ss`.`productos` 
( `id` INT(11) NOT NULL , 
`descripcion` VARCHAR(255) NOT NULL , 
`precio` FLOAT(11) NOT NULL , 
`tipoProducto` INT(2) NOT NULL , 
`fechaBaja` DATE NULL DEFAULT NULL , 
PRIMARY KEY (`id`)) 
ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `productos` CHANGE `id` `id` INT(11) NOT NULL AUTO_INCREMENT;
--Agrego clave foranea
ALTER TABLE productos ADD FOREIGN KEY (tipoProducto) REFERENCES tipoProducto(codTipoProducto)
--Creacion de la tabla empleados
CREATE TABLE `Hi5USsV2ss`.`empleados` 
( `id` INT(11) NOT NULL AUTO_INCREMENT , 
`usuario` VARCHAR(255) NOT NULL , 
`clave` VARCHAR(255) NOT NULL , 
`nombre` VARCHAR(255) NOT NULL , 
`apellido` VARCHAR(255) NOT NULL , 
`tipoEmpleado` INT(2) NOT NULL , 
`fechaBaja` DATE NULL DEFAULT NULL , 
PRIMARY KEY (`id`))
 ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_unicode_ci;
 --Agrego clave foranea
 ALTER TABLE empleados ADD FOREIGN KEY (tipoEmpleado) REFERENCES tipoEmpleado(codTipoEmpleado)

