-- phpMyAdmin SQL Dump
-- version 2.10.3
-- http://www.phpmyadmin.net
-- 
-- Servidor: localhost
-- Tiempo de generación: 27-01-2013 a las 01:01:40
-- Versión del servidor: 5.0.51
-- Versión de PHP: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- Base de datos: `tedi`
-- 

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `alimentos`
-- 

CREATE TABLE `alimentos` (
  `idalimentos` int(10) unsigned NOT NULL auto_increment,
  `categoria` varchar(255) default NULL,
  `nombre` varchar(255) default NULL,
  `porcion_popular` varchar(255) default NULL,
  `porcion_gramos` int(10) unsigned default NULL,
  `calorias_porcion` int(10) unsigned default NULL,
  `unidad_medida` varchar(25) default NULL,
  PRIMARY KEY  (`idalimentos`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=244 ;

-- 
-- Volcar la base de datos para la tabla `alimentos`
-- 

INSERT INTO `alimentos` VALUES (1, 'BEBIDAS', 'Merengada (helado)', '1 vaso', 0, 375, 'cc');
INSERT INTO `alimentos` VALUES (2, 'BEBIDAS', 'Chicha de arroz', '1 vaso', 0, 245, 'cc');
INSERT INTO `alimentos` VALUES (3, 'BEBIDAS', 'Lactovisoy (bebida l', '1 vaso', 0, 191, 'cc');
INSERT INTO `alimentos` VALUES (4, 'BEBIDAS', 'Malta', '1 vaso o bot.', 0, 150, 'cc');
INSERT INTO `alimentos` VALUES (5, 'BEBIDAS', 'Gaseosa regular', '1 lata', 0, 170, 'cc');
INSERT INTO `alimentos` VALUES (6, 'BEBIDAS', 'Gaseosa regular', '1 vaso', 0, 120, 'cc');
INSERT INTO `alimentos` VALUES (7, 'BEBIDAS', 'Jugo de manzana', '1 vaso', 0, 120, 'cc');
INSERT INTO `alimentos` VALUES (8, 'BEBIDAS', 'Papel', '1 vaso', 0, 95, 'cc');
INSERT INTO `alimentos` VALUES (9, 'BEBIDAS', 'Malta ligera', '1 vaso o bot.', 0, 75, 'cc');
INSERT INTO `alimentos` VALUES (10, 'BEBIDAS', 'Bebida deportiva', '1 vaso', 0, 60, 'cc');
INSERT INTO `alimentos` VALUES (11, 'BEBIDAS', 'Jugo de tomate', '1 vaso', 0, 43, 'cc');
INSERT INTO `alimentos` VALUES (12, 'BEBIDAS', 'Gaseosa ligera', '1 vaso', 0, 1, 'cc');
INSERT INTO `alimentos` VALUES (13, 'BEBIDAS', 'T', '1 taza', 0, 2, 'cc');
INSERT INTO `alimentos` VALUES (14, 'BEBIDAS', 'Caf', '1 taza', 0, 1, 'cc');
INSERT INTO `alimentos` VALUES (15, 'BEBIDAS', 'Avena en atol', '1 taza', 0, 244, 'cc');
INSERT INTO `alimentos` VALUES (16, 'BEBIDAS', 'Jugo de fruta envasado ', '1 vaso', 250, 135, 'cc');
INSERT INTO `alimentos` VALUES (17, 'BEBIDAS', 'Naranjada', '1 vaso', 0, 130, 'cc');
INSERT INTO `alimentos` VALUES (18, 'BEBIDAS', 'Jugo de naranja natural', '1 vaso', 0, 120, 'cc');
INSERT INTO `alimentos` VALUES (19, 'BEBIDAS', 'Naranjada ligera', '1 botella', 0, 80, 'cc');
INSERT INTO `alimentos` VALUES (20, 'BEBIDAS', 'Jugo de pera', '1 vaso', 0, 80, 'cc');
INSERT INTO `alimentos` VALUES (21, 'BEBIDAS', 'Jugo de fruta ligero', '1 vaso', 0, 40, 'cc');
INSERT INTO `alimentos` VALUES (22, 'BEBIDAS', 'Crema de leche para batir', ' 1/2 taza', 0, 350, 'g');
INSERT INTO `alimentos` VALUES (23, 'BEBIDAS', 'Bebida l', '1 botella mediana', 0, 0, 'cc ');
INSERT INTO `alimentos` VALUES (24, 'BEBIDAS', 'Crema de leche regular', '1/2 taza', 0, 250, 'g');
INSERT INTO `alimentos` VALUES (25, 'BEBIDAS', 'Yogurt firme con fruta', '1 raci', 0, 230, 'cc ');
INSERT INTO `alimentos` VALUES (26, 'BEBIDAS', 'Bebida l', '3/4 taza', 0, 170, 'cc');
INSERT INTO `alimentos` VALUES (27, 'BEBIDAS', 'Yogurt dulce con hojuelas de ma', '1 taza', 0, 170, 'cc');
INSERT INTO `alimentos` VALUES (28, 'BEBIDAS', 'Yogurt firme', '1 raci', 0, 160, 'cc');
INSERT INTO `alimentos` VALUES (29, 'BEBIDAS', 'Crema de leche ligera', '1/2 taza', 0, 160, 'g');
INSERT INTO `alimentos` VALUES (30, 'BEBIDAS', 'Leche completa', '1 taza', 0, 150, 'cc');
INSERT INTO `alimentos` VALUES (31, 'BEBIDAS', 'Yogurt firme natural', '1 mediano', 150, 120, 'cc');
INSERT INTO `alimentos` VALUES (32, 'BEBIDAS', 'Yogurt dulce ligero con hojuelas', '1 mediano', 0, 130, 'cc');
INSERT INTO `alimentos` VALUES (33, 'BEBIDAS', 'Bebida l', '1 botella mediana', 300, 120, 'cc');
INSERT INTO `alimentos` VALUES (34, 'BEBIDAS', 'Leche semi-descremada', '1 taza', 0, 120, 'cc ');
INSERT INTO `alimentos` VALUES (35, 'BEBIDAS', 'Yogurt l', '1 botella peque', 0, 119, 'cc');
INSERT INTO `alimentos` VALUES (36, 'BEBIDAS', 'Yogurt natural l', '1 raci', 0, 92, 'cc ');
INSERT INTO `alimentos` VALUES (37, 'BEBIDAS', 'Leche descremada', '1 taza', 0, 80, 'cc');
INSERT INTO `alimentos` VALUES (38, 'BEBIDAS', 'Yogurt firme ligero', '1 mediano', 0, 70, 'cc');
INSERT INTO `alimentos` VALUES (39, 'BEBIDAS', 'Crema espesa', '1 cucharada', 0, 70, 'g');
INSERT INTO `alimentos` VALUES (40, 'BEBIDAS', 'Nata', '1 cucharada', 0, 66, 'g');
INSERT INTO `alimentos` VALUES (41, 'BEBIDAS', 'Leche condensada', '1 cucharada', 0, 64, 'g');
INSERT INTO `alimentos` VALUES (42, 'AZ', 'Papel', '1 cucharada', 15, 0, 'g');
INSERT INTO `alimentos` VALUES (43, 'AZ', 'Miel de abeja', '1 cucharada', 15, 48, 'g');
INSERT INTO `alimentos` VALUES (44, 'AZ', 'Az', '1 cucharadita/bolsita', 4, 16, 'g');
INSERT INTO `alimentos` VALUES (45, 'AZ', 'Az', '1 cucharadita', 4, 15, 'g');
INSERT INTO `alimentos` VALUES (46, 'AZ', 'Edulcorante', '1', 1, 4, 'g');
INSERT INTO `alimentos` VALUES (47, 'DESAYUNO', 'Granola', 'media taza', 150, 0, 'g');
INSERT INTO `alimentos` VALUES (48, 'DESAYUNO', 'Avena en hojuelas con miel y leche descremada', '1 taza total', 0, 200, 'g');
INSERT INTO `alimentos` VALUES (49, 'DESAYUNO', 'Arepa ( Harina integral 50 g)', 'una mediana', 100, 178, 'g');
INSERT INTO `alimentos` VALUES (50, 'DESAYUNO', 'Arepa ( Harina precocida 50 g)', 'una mediana', 100, 175, 'g');
INSERT INTO `alimentos` VALUES (51, 'DESAYUNO', 'Hallaquita', 'una mediana', 100, 175, 'g');
INSERT INTO `alimentos` VALUES (52, 'DESAYUNO', 'Hojuelas de cereal con media taza de leche descremada', '1 taza total', 30, 200, 'g');
INSERT INTO `alimentos` VALUES (53, 'DESAYUNO', 'Hojuelas de ma', '1 taza total', 30, 140, 'g');
INSERT INTO `alimentos` VALUES (54, 'DESAYUNO', 'Pan blanco', '2 rebanadas', 0, 134, 'g');
INSERT INTO `alimentos` VALUES (55, 'DESAYUNO', 'Cachapa', 'una mediana', 100, 137, 'g');
INSERT INTO `alimentos` VALUES (56, 'DESAYUNO', 'Pan integral', '2 rebanadas', 60, 162, 'g');
INSERT INTO `alimentos` VALUES (57, 'DESAYUNO', 'Pan redondo de hamburguesa', 'una unidad', 50, 120, 'g');
INSERT INTO `alimentos` VALUES (58, 'DESAYUNO', 'Casabe en galleta', '5 unidades', 25, 90, 'g');
INSERT INTO `alimentos` VALUES (59, 'DESAYUNO', 'Pan integral ligero', '2 rebanadas', 56, 80, 'g');
INSERT INTO `alimentos` VALUES (60, 'DESAYUNO', 'Galletas de soda integral', '1 paquete de 3', 0, 129, 'g');
INSERT INTO `alimentos` VALUES (61, 'DESAYUNO', 'Galleta de soda (tipo club social) regular ', '1 paquete', 0, 110, 'g');
INSERT INTO `alimentos` VALUES (62, 'DESAYUNO', 'Galleta de soda', '1 paquete', 0, 100, 'g');
INSERT INTO `alimentos` VALUES (63, 'FRUTAS', 'Cambur', '1 mediano', 0, 96, 'g');
INSERT INTO `alimentos` VALUES (64, 'FRUTAS', 'Compota infantil de fruta', '1 frasco', 0, 80, 'g');
INSERT INTO `alimentos` VALUES (65, 'FRUTAS', 'Ensalada de fruta enlatada', '1 taza', 120, 84, 'g');
INSERT INTO `alimentos` VALUES (66, 'FRUTAS', 'N', '1 mediano', 0, 71, 'g');
INSERT INTO `alimentos` VALUES (67, 'FRUTAS', 'Uvas', '15 unidades', 0, 70, 'g');
INSERT INTO `alimentos` VALUES (68, 'FRUTAS', 'Mango', '3/4 taza', 150, 69, 'g');
INSERT INTO `alimentos` VALUES (69, 'FRUTAS', 'Pera', '1 unidad', 0, 63, 'g');
INSERT INTO `alimentos` VALUES (70, 'FRUTAS', 'Lechoza', '3/4 taza', 0, 53, 'g');
INSERT INTO `alimentos` VALUES (71, 'FRUTAS', 'Manzana', '1 mediana', 0, 71, 'g');
INSERT INTO `alimentos` VALUES (72, 'FRUTAS', 'Pi', '1 rueda', 0, 52, 'g');
INSERT INTO `alimentos` VALUES (73, 'FRUTAS', 'Mel', '1 taza', 0, 40, 'g');
INSERT INTO `alimentos` VALUES (74, 'FRUTAS', 'Fresas', '8 unidades', 0, 37, 'g');
INSERT INTO `alimentos` VALUES (75, 'FRUTAS', 'Naranja', '1 mediana', 0, 40, 'g');
INSERT INTO `alimentos` VALUES (76, 'FRUTAS', 'Mandarina', '1 mediana', 0, 33, 'g');
INSERT INTO `alimentos` VALUES (77, 'FRUTAS', 'Patilla', '1 taza', 0, 23, 'g');
INSERT INTO `alimentos` VALUES (78, 'FRUTAS', 'Guayaba', '1 mediana', 0, 20, 'g');
INSERT INTO `alimentos` VALUES (79, 'CARNES', 'Chicharr', '1 porci', 50, 323, 'g');
INSERT INTO `alimentos` VALUES (80, 'CARNES', 'Chuleta de Cerdo', '1 unidad', 100, 305, 'g');
INSERT INTO `alimentos` VALUES (81, 'CARNES', 'Costillas de Cerdo', '1 porci', 100, 295, 'g');
INSERT INTO `alimentos` VALUES (82, 'CARNES', 'Morcilla', '1 unidad', 100, 250, 'g');
INSERT INTO `alimentos` VALUES (83, 'CARNES', 'Chuleta ahumada de Cerdo', '1 chuleta mediana', 120, 241, 'g');
INSERT INTO `alimentos` VALUES (84, 'CARNES', 'Lomo de cerdo', '1 porci', 100, 202, 'g');
INSERT INTO `alimentos` VALUES (85, 'CARNES', 'Tocineta frita', '3 tiritas', 36, 195, 'g');
INSERT INTO `alimentos` VALUES (86, 'CARNES', 'Pernil de cerdo sin grasa visible', '1 porci', 120, 145, 'g');
INSERT INTO `alimentos` VALUES (87, 'CARNES', 'Pavo, pechuga', '1 porci', 120, 150, 'g');
INSERT INTO `alimentos` VALUES (88, 'CARNES', 'Pollo, muslo sin piel', '2 muslos', 120, 138, 'g');
INSERT INTO `alimentos` VALUES (89, 'CARNES', 'Pollo, pierna sin piel', '2 piernas', 120, 136, 'g');
INSERT INTO `alimentos` VALUES (90, 'CARNES', 'Pollo, pechuga sin piel', 'media pechuga', 120, 124, 'g');
INSERT INTO `alimentos` VALUES (91, 'CARNES', 'Ensalada de at', '1 lata mediana', 135, 261, 'g');
INSERT INTO `alimentos` VALUES (92, 'CARNES', 'Sardinas enlatadas', '1 lata peque', 117, 222, 'g');
INSERT INTO `alimentos` VALUES (93, 'CARNES', 'At', '1 lata peque', 110, 178, 'g');
INSERT INTO `alimentos` VALUES (94, 'CARNES', 'Salm', '1 filet mediano', 100, 120, 'g');
INSERT INTO `alimentos` VALUES (95, 'CARNES', 'Mero', '1 filet mediano', 120, 114, 'g');
INSERT INTO `alimentos` VALUES (96, 'CARNES', 'Pargo', '1 filet mediano', 120, 98, 'g');
INSERT INTO `alimentos` VALUES (97, 'CARNES', 'At', '1 lata peque', 0, 98, 'g');
INSERT INTO `alimentos` VALUES (98, 'ARROZ, PASTAS Y AFINES ', 'Papas fritas', '', 114, 380, 'g');
INSERT INTO `alimentos` VALUES (99, 'ARROZ, PASTAS Y AFINES ', 'Pl', '', 150, 262, 'g');
INSERT INTO `alimentos` VALUES (100, 'ARROZ, PASTAS Y AFINES ', 'Pl', 'medio p', 150, 246, 'g');
INSERT INTO `alimentos` VALUES (101, 'ARROZ, PASTAS Y AFINES ', 'Yuca pelada y congelada', 'un trozo y medio', 190, 243, 'g');
INSERT INTO `alimentos` VALUES (102, 'ARROZ, PASTAS Y AFINES ', 'Papa grande horneada', 'una unidad', 150, 200, 'g');
INSERT INTO `alimentos` VALUES (103, 'ARROZ, PASTAS Y AFINES ', 'Pasta cocida sin salsa', 'una taza', 150, 197, 'g');
INSERT INTO `alimentos` VALUES (104, 'ARROZ, PASTAS Y AFINES ', 'Yuca cocida', 'una taza', 150, 194, 'g');
INSERT INTO `alimentos` VALUES (105, 'ARROZ, PASTAS Y AFINES ', 'Pl', 'medio pl', 150, 172, 'g');
INSERT INTO `alimentos` VALUES (106, 'ARROZ, PASTAS Y AFINES ', 'Arroz blanco cocido', 'una taza', 150, 160, 'g');
INSERT INTO `alimentos` VALUES (107, 'ARROZ, PASTAS Y AFINES ', 'Papa cocida', 'una taza', 150, 150, 'g');
INSERT INTO `alimentos` VALUES (108, 'ARROZ, PASTAS Y AFINES ', 'Pl', 'medio pl', 150, 136, 'g');
INSERT INTO `alimentos` VALUES (109, 'ARROZ, PASTAS Y AFINES ', 'Garbanzos', '1 porci', 0, 150, 'cc');
INSERT INTO `alimentos` VALUES (110, 'ARROZ, PASTAS Y AFINES ', 'Caraotas negras', '1 porci', 0, 130, 'cc');
INSERT INTO `alimentos` VALUES (111, 'ARROZ, PASTAS Y AFINES ', 'Caraotas blancas', ' 1 porci', 0, 120, 'cc');
INSERT INTO `alimentos` VALUES (112, 'ARROZ, PASTAS Y AFINES ', 'Arvejas', '1 botella', 0, 80, 'cc');
INSERT INTO `alimentos` VALUES (113, 'ARROZ, PASTAS Y AFINES ', 'Lentejas', '1 porci', 0, 80, 'cc');
INSERT INTO `alimentos` VALUES (114, 'ARROZ, PASTAS Y AFINES ', 'Caraotas blancas en salsa de tomate', '1 vaso', 0, 40, 'cc');
INSERT INTO `alimentos` VALUES (115, 'ACEITE,SALSAS Y OTROS PAR UNTAR', 'Salsa tipo ranchera', '2 cucharadas', 0, 230, 'g');
INSERT INTO `alimentos` VALUES (116, 'ACEITE,SALSAS Y OTROS PAR UNTAR', 'Salsa tipo', '2 cucharadas', 0, 160, 'g');
INSERT INTO `alimentos` VALUES (117, 'ACEITE,SALSAS Y OTROS PAR UNTAR', 'Salsa de tomate con carne enlatada', 'media taza', 150, 140, 'g');
INSERT INTO `alimentos` VALUES (118, 'ACEITE,SALSAS Y OTROS PAR UNTAR', 'Jam', 'una lata peque', 0, 140, 'g');
INSERT INTO `alimentos` VALUES (119, 'ACEITE,SALSAS Y OTROS PAR UNTAR', 'Jam', '', 0, 76, 'g');
INSERT INTO `alimentos` VALUES (120, 'ACEITE,SALSAS Y OTROS PAR UNTAR', 'Aceite', '1 cucharada', 15, 135, 'g');
INSERT INTO `alimentos` VALUES (121, 'ACEITE,SALSAS Y OTROS PAR UNTAR', 'Mayonesa regular', '1 cucharada', 15, 100, 'g');
INSERT INTO `alimentos` VALUES (122, 'ACEITE,SALSAS Y OTROS PAR UNTAR', 'Margarina ', '1 cucharada', 15, 110, 'g');
INSERT INTO `alimentos` VALUES (123, 'ACEITE,SALSAS Y OTROS PAR UNTAR', 'Vinagreta', '2 cucharadas', 0, 110, 'g');
INSERT INTO `alimentos` VALUES (124, 'ACEITE,SALSAS Y OTROS PAR UNTAR', 'Pasta con sabor a queso', '2 cucharadas', 0, 95, 'g');
INSERT INTO `alimentos` VALUES (125, 'ACEITE,SALSAS Y OTROS PAR UNTAR', 'Queso fundido para untar', '2 cucharadas', 0, 81, 'g');
INSERT INTO `alimentos` VALUES (126, 'ACEITE,SALSAS Y OTROS PAR UNTAR', 'Queso crema', '2 cucharadas', 0, 80, 'g');
INSERT INTO `alimentos` VALUES (127, 'ACEITE,SALSAS Y OTROS PAR UNTAR', 'Margarina ligera', '1 cucharada', 0, 60, 'g');
INSERT INTO `alimentos` VALUES (128, 'ACEITE,SALSAS Y OTROS PAR UNTAR', 'Reques', '2 cucharadas', 0, 70, 'g');
INSERT INTO `alimentos` VALUES (129, 'ACEITE,SALSAS Y OTROS PAR UNTAR', 'Nata', '1 cucharada', 0, 65, 'g');
INSERT INTO `alimentos` VALUES (130, 'ACEITE,SALSAS Y OTROS PAR UNTAR', 'Mermelada', '1 cucharada', 0, 60, 'g');
INSERT INTO `alimentos` VALUES (131, 'ACEITE,SALSAS Y OTROS PAR UNTAR', 'Pasta de h', '1 cucharada', 0, 53, 'g');
INSERT INTO `alimentos` VALUES (132, 'ACEITE,SALSAS Y OTROS PAR UNTAR', 'Salsa de mostaza y miel', '1 porci', 0, 50, 'g');
INSERT INTO `alimentos` VALUES (133, 'ACEITE,SALSAS Y OTROS PAR UNTAR', 'Mayonesa ligera', '1 cucharada', 0, 44, 'g');
INSERT INTO `alimentos` VALUES (134, 'ACEITE,SALSAS Y OTROS PAR UNTAR', 'Mermelada baja en az', '1 cucharada', 0, 25, 'g');
INSERT INTO `alimentos` VALUES (135, 'ACEITE,SALSAS Y OTROS PAR UNTAR', 'Vinagre bals', '1 cucharada', 0, 20, 'g');
INSERT INTO `alimentos` VALUES (136, 'ACEITE,SALSAS Y OTROS PAR UNTAR', 'Salsa de tomate tipo ketchup', '10g', 0, 10, 'g');
INSERT INTO `alimentos` VALUES (137, 'ACEITE,SALSAS Y OTROS PAR UNTAR', 'Mostaza', '1 cucharada', 0, 13, 'g');
INSERT INTO `alimentos` VALUES (138, 'ACEITE,SALSAS Y OTROS PAR UNTAR', 'Vinagre blanco', '1 cucharada', 0, 1, 'g');
INSERT INTO `alimentos` VALUES (139, 'EMBUTIDOS', 'Salchicha de cerdo', '', 100, 182, 'g');
INSERT INTO `alimentos` VALUES (140, 'EMBUTIDOS', 'Salchich', '1 rodaja', 0, 140, 'g');
INSERT INTO `alimentos` VALUES (141, 'EMBUTIDOS', 'Mortadela', '1 unidad', 0, 140, 'g');
INSERT INTO `alimentos` VALUES (142, 'EMBUTIDOS', 'Tocineta', ' 2 tiras', 0, 120, 'g');
INSERT INTO `alimentos` VALUES (143, 'EMBUTIDOS', 'Chorizo tipo espa', '1 unidad', 0, 114, 'g');
INSERT INTO `alimentos` VALUES (144, 'EMBUTIDOS', 'Salchicha de pavo', '1 unidad', 100, 102, 'g');
INSERT INTO `alimentos` VALUES (145, 'EMBUTIDOS', 'Jam', '2 rebanadas', 50, 88, 'g');
INSERT INTO `alimentos` VALUES (146, 'EMBUTIDOS', 'Bolo', '', 50, 80, 'g');
INSERT INTO `alimentos` VALUES (147, 'EMBUTIDOS', 'Jam', '2 rebanadas', 50, 54, 'g');
INSERT INTO `alimentos` VALUES (148, 'EMBUTIDOS', 'Jam', '', 50, 50, 'g');
INSERT INTO `alimentos` VALUES (149, 'EMBUTIDOS', 'Pechuga de pavo', '', 50, 40, 'g');
INSERT INTO `alimentos` VALUES (150, 'EMBUTIDOS', 'Pechuga de pollo', '', 50, 40, 'g');
INSERT INTO `alimentos` VALUES (151, 'LEGUMBRES CRUDAS', 'Aguacate', ' 3/4 taza', 100, 152, 'g');
INSERT INTO `alimentos` VALUES (152, 'LEGUMBRES CRUDAS', 'Zanahorias', '3/4 taza', 100, 32, 'g');
INSERT INTO `alimentos` VALUES (153, 'LEGUMBRES CRUDAS', 'Acelgas, espinacas', '3/4 taza', 120, 29, 'g');
INSERT INTO `alimentos` VALUES (154, 'LEGUMBRES CRUDAS', 'Tomate en lata', '1/2 taza', 100, 20, 'g');
INSERT INTO `alimentos` VALUES (155, 'LEGUMBRES CRUDAS', 'Tomate', '1/2 taza', 100, 16, 'g');
INSERT INTO `alimentos` VALUES (156, 'LEGUMBRES CRUDAS', 'Piment', '1/4 taza', 50, 12, 'g');
INSERT INTO `alimentos` VALUES (157, 'LEGUMBRES CRUDAS', 'Pepino', ' 1/2 taza', 0, 11, 'g');
INSERT INTO `alimentos` VALUES (158, 'LEGUMBRES CRUDAS', 'Berro', ' 1/2 taza', 0, 10, 'g');
INSERT INTO `alimentos` VALUES (159, 'LEGUMBRES CRUDAS', 'Cebolla', '1/4 taza', 0, 10, 'g');
INSERT INTO `alimentos` VALUES (160, 'LEGUMBRES CRUDAS', 'Lechuga', '1/2 taza', 0, 0, 'g');
INSERT INTO `alimentos` VALUES (161, 'LEGUMBRES COCINADAS', 'Mazorca de ma', '', 200, 178, 'g');
INSERT INTO `alimentos` VALUES (162, 'LEGUMBRES COCINADAS', 'Ocumo', '1/2 taza', 100, 109, 'g');
INSERT INTO `alimentos` VALUES (163, 'LEGUMBRES COCINADAS', 'Apio', '', 100, 93, 'g');
INSERT INTO `alimentos` VALUES (164, 'LEGUMBRES COCINADAS', 'Ma', '1/2 taza', 125, 90, 'g');
INSERT INTO `alimentos` VALUES (165, 'LEGUMBRES COCINADAS', 'Ma', '1/2 taza', 100, 85, 'g');
INSERT INTO `alimentos` VALUES (166, 'LEGUMBRES COCINADAS', 'Guisantes congelados', '1/2 taza', 125, 80, 'g');
INSERT INTO `alimentos` VALUES (167, 'LEGUMBRES COCINADAS', 'Guisantes y zanahorias congelados', '1/4 taza', 85, 78, 'g');
INSERT INTO `alimentos` VALUES (168, 'LEGUMBRES COCINADAS', 'Guisantes enlatados', '1/2 taza', 125, 60, 'g');
INSERT INTO `alimentos` VALUES (169, 'LEGUMBRES COCINADAS', 'Palmito', '2 trozos', 145, 55, 'g');
INSERT INTO `alimentos` VALUES (170, 'LEGUMBRES COCINADAS', 'Vegetales mixtos enlatados', '1/2 taza', 125, 45, 'g');
INSERT INTO `alimentos` VALUES (171, 'LEGUMBRES COCINADAS', 'Alcachofa enlatada', '1/2 taza', 125, 35, 'g');
INSERT INTO `alimentos` VALUES (172, 'LEGUMBRES COCINADAS', 'Remolacha', '1/2 taza', 100, 35, 'g');
INSERT INTO `alimentos` VALUES (173, 'LEGUMBRES COCINADAS', 'Auyama', '1/2 taza', 100, 30, 'g');
INSERT INTO `alimentos` VALUES (174, 'LEGUMBRES COCINADAS', 'Br', '1/2 taza', 100, 30, 'g');
INSERT INTO `alimentos` VALUES (175, 'LEGUMBRES COCINADAS', 'Vegetales mixtos congelados', '1/2 taza', 125, 30, 'g');
INSERT INTO `alimentos` VALUES (176, 'LEGUMBRES COCINADAS', 'Chayota', '3/4 taza', 150, 25, 'g');
INSERT INTO `alimentos` VALUES (177, 'LEGUMBRES COCINADAS', 'Berenjena', '1/2 taza', 100, 22, 'g');
INSERT INTO `alimentos` VALUES (178, 'LEGUMBRES COCINADAS', 'Espinacas/acelgas', '1/2 taza', 125, 20, 'g');
INSERT INTO `alimentos` VALUES (179, 'LEGUMBRES COCINADAS', 'Vainitas', '1/2 taza', 100, 15, 'g');
INSERT INTO `alimentos` VALUES (180, 'LEGUMBRES COCINADAS', 'Coliflor', '1/2 taza', 100, 14, 'g');
INSERT INTO `alimentos` VALUES (181, 'LEGUMBRES COCINADAS', 'Pepinillos en vinagre', '1 grande', 30, 12, 'g');
INSERT INTO `alimentos` VALUES (182, 'LEGUMBRES COCINADAS', 'Calabac', '1/2 taza', 100, 10, 'g');
INSERT INTO `alimentos` VALUES (183, 'QUESOS', 'Amarillo holand', '2 rebanadas', 50, 199, 'g');
INSERT INTO `alimentos` VALUES (184, 'QUESOS', 'Amarillo americano', '2 rebanadas', 50, 188, 'g');
INSERT INTO `alimentos` VALUES (185, 'QUESOS', 'Blanco suave', '2 rebanadas', 50, 165, 'g');
INSERT INTO `alimentos` VALUES (186, 'QUESOS', 'Mozarela', '2 rebanadas', 50, 119, 'g');
INSERT INTO `alimentos` VALUES (187, 'QUESOS', 'Parmesano rallado', '1 cucharada', 25, 100, 'g');
INSERT INTO `alimentos` VALUES (188, 'QUESOS', 'Blanco duro rallado', '1 cucharada', 25, 100, 'g');
INSERT INTO `alimentos` VALUES (189, 'QUESOS', 'Queso crema', '2 cucharadas', 30, 113, 'g');
INSERT INTO `alimentos` VALUES (190, 'QUESOS', 'Reques', '2 cucharadas', 30, 50, 'g');
INSERT INTO `alimentos` VALUES (191, 'POSTRES Y DULCES', 'Tortas y pasteles', '1 porci', 120, 345, 'g');
INSERT INTO `alimentos` VALUES (192, 'POSTRES Y DULCES', 'Brazo gitano', '1 porci', 115, 290, 'g');
INSERT INTO `alimentos` VALUES (193, 'POSTRES Y DULCES', 'Helados', '1 taza', 150, 270, 'g');
INSERT INTO `alimentos` VALUES (194, 'POSTRES Y DULCES', 'Donuts', '1 unidad', 120, 175, 'g');
INSERT INTO `alimentos` VALUES (195, 'POSTRES Y DULCES', 'Chocolate en barra', '1 barra', 28, 170, 'g');
INSERT INTO `alimentos` VALUES (196, 'POSTRES Y DULCES', 'Chocolate en barra', '1 barra', 50, 226, 'g');
INSERT INTO `alimentos` VALUES (197, 'POSTRES Y DULCES', 'Torta casera ', '1 porci', 120, 155, 'g');
INSERT INTO `alimentos` VALUES (198, 'POSTRES Y DULCES', 'Dulces de leche (arequipe)', '3 cucharadas', 50, 160, 'g');
INSERT INTO `alimentos` VALUES (199, 'POSTRES Y DULCES', 'Pasta dulce de avellana', '2 cucharadas', 30, 160, 'g');
INSERT INTO `alimentos` VALUES (200, 'POSTRES Y DULCES', 'Sorbete ', '1 taza', 150, 101, 'g');
INSERT INTO `alimentos` VALUES (201, 'POSTRES Y DULCES', 'Mermeladas', '1 cucharada', 20, 56, 'g');
INSERT INTO `alimentos` VALUES (202, 'POSTRES Y DULCES', 'Ensalada de fruta enlatada', '1 taza', 120, 84, 'g');
INSERT INTO `alimentos` VALUES (203, 'POSTRES Y DULCES', 'Gelatina regular', '1/2 taza', 100, 65, 'g');
INSERT INTO `alimentos` VALUES (204, 'POSTRES Y DULCES', 'Gelatina ligera', '1/2 taza', 100, 10, 'g');
INSERT INTO `alimentos` VALUES (205, 'POSTRES Y DULCES', 'Galleta rellena con crema de coco', '1 paquete', 0, 250, 'g');
INSERT INTO `alimentos` VALUES (206, 'POSTRES Y DULCES', 'Galletas negras rellenas dobles', '4 galletas', 0, 220, 'g');
INSERT INTO `alimentos` VALUES (207, 'POSTRES Y DULCES', 'Galletas negras rellenas', '4 galletas', 0, 170, 'g');
INSERT INTO `alimentos` VALUES (208, 'POSTRES Y DULCES', 'Galletas dulces (tipo Mar', '1 paquete de 4', 0, 126, 'g');
INSERT INTO `alimentos` VALUES (209, 'PASABOCAS', 'Papas fritas', '1 porci', 170, 570, 'g');
INSERT INTO `alimentos` VALUES (210, 'PASABOCAS', 'Papas fritas', '1 porci', 114, 380, 'g');
INSERT INTO `alimentos` VALUES (211, 'PASABOCAS', 'Papas fritas', '1 porci', 74, 250, 'g');
INSERT INTO `alimentos` VALUES (212, 'PASABOCAS', 'Palitos de ma', '1 paquete mediano', 54, 257, 'g');
INSERT INTO `alimentos` VALUES (213, 'PASABOCAS', 'Papitas (chips)', '1 paquete mediano', 40, 241, 'g');
INSERT INTO `alimentos` VALUES (214, 'PASABOCAS', 'Tri', '1 paquete mediano', 45, 220, 'g');
INSERT INTO `alimentos` VALUES (215, 'PASABOCAS', 'Tostones', '1 bolsa mediana', 45, 220, 'g');
INSERT INTO `alimentos` VALUES (216, 'PASABOCAS', 'Tostones', '1 bolsa peque', 28, 140, 'g');
INSERT INTO `alimentos` VALUES (217, 'PASABOCAS', 'Avellanas', '2 cucharadas', 30, 187, 'g');
INSERT INTO `alimentos` VALUES (218, 'PASABOCAS', 'Man', '2 cucharadas', 30, 175, 'g');
INSERT INTO `alimentos` VALUES (219, 'PASABOCAS', 'Cotufa', '3 tazas', 30, 112, 'g');
INSERT INTO `alimentos` VALUES (220, 'PASABOCAS', 'Chicharrones', '1 paquete', 20, 104, 'g');
INSERT INTO `alimentos` VALUES (221, 'COMIDAS PREPARADAS', 'Perro caliente', '1 mediano', 0, 300, 'g');
INSERT INTO `alimentos` VALUES (222, 'COMIDAS PREPARADAS', 'Empanada de carne', '1 mediana', 0, 280, 'g');
INSERT INTO `alimentos` VALUES (223, 'COMIDAS PREPARADAS', 'Carne mechada frita', '1/2 taza', 100, 250, 'g');
INSERT INTO `alimentos` VALUES (224, 'COMIDAS PREPARADAS', 'Hamburguesa con queso', '1 grande', 0, 520, 'g');
INSERT INTO `alimentos` VALUES (225, 'COMIDAS PREPARADAS', 'Hamburguesa con queso', '1 peque', 0, 250, 'g');
INSERT INTO `alimentos` VALUES (226, 'COMIDAS PREPARADAS', 'Mondongo', '1 plato hondo', 250, 238, 'g');
INSERT INTO `alimentos` VALUES (227, 'COMIDAS PREPARADAS', 'Taco', '1 unidad', 0, 186, 'g');
INSERT INTO `alimentos` VALUES (228, 'COMIDAS PREPARADAS', 'Sancocho de gallina', '1 plato hondo', 250, 185, 'g');
INSERT INTO `alimentos` VALUES (229, 'COMIDAS PREPARADAS', 'Pizza', '1 porci', 150, 178, 'g');
INSERT INTO `alimentos` VALUES (230, 'COMIDAS PREPARADAS', 'Salchicha de carne de res', '1 grande', 75, 173, 'g');
INSERT INTO `alimentos` VALUES (231, 'COMIDAS PREPARADAS', 'Hervido de res', '1 plato hondo', 250, 150, 'g');
INSERT INTO `alimentos` VALUES (232, 'COMIDAS PREPARADAS', 'Huevo cocido', '1 unidad', 80, 0, 'g');
INSERT INTO `alimentos` VALUES (233, 'BEBIDAS ALCOHLICAS', 'Brandy', '1 copa', 80, 200, 'cc');
INSERT INTO `alimentos` VALUES (234, 'BEBIDAS ALCOHLICAS', 'Ron', '1 trago', 60, 180, 'cc');
INSERT INTO `alimentos` VALUES (235, 'BEBIDAS ALCOHLICAS', 'Cerveza', '1 lata grande', 350, 150, 'cc');
INSERT INTO `alimentos` VALUES (236, 'BEBIDAS ALCOHLICAS', 'Cerveza', '1 lata peque', 250, 120, 'cc');
INSERT INTO `alimentos` VALUES (237, 'BEBIDAS ALCOHLICAS', 'Vodka, wisky ', '1 trago', 60, 140, 'cc');
INSERT INTO `alimentos` VALUES (238, 'BEBIDAS ALCOHLICAS', 'Vino dulce tipo moscatel', '1 copa', 120, 130, 'cc');
INSERT INTO `alimentos` VALUES (239, 'BEBIDAS ALCOHLICAS', 'Jerez, vino blanco ', '1 copa', 120, 125, 'cc');
INSERT INTO `alimentos` VALUES (240, 'BEBIDAS ALCOHLICAS', 'Vermut', '1 copa', 120, 120, 'cc');
INSERT INTO `alimentos` VALUES (241, 'BEBIDAS ALCOHLICAS', 'Aguardiente', '1 trago', 30, 90, 'cc');
INSERT INTO `alimentos` VALUES (242, 'BEBIDAS ALCOHLICAS', 'Champagne', '1 copa', 120, 84, 'cc');
INSERT INTO `alimentos` VALUES (243, 'BEBIDAS ALCOHLICAS', 'Cerveza ligera', '1 lata peque', 0, 75, 'cc');

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `dieta`
-- 

CREATE TABLE `dieta` (
  `iddieta` int(10) unsigned NOT NULL auto_increment,
  `usuario_idUSUARIO` int(10) unsigned NOT NULL,
  `numero_alimentacion` int(10) unsigned default NULL,
  `tipo_dieta` int(10) unsigned default NULL,
  PRIMARY KEY  (`iddieta`),
  KEY `dieta_FKIndex1` (`usuario_idUSUARIO`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `dieta`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `historial_dieta`
-- 

CREATE TABLE `historial_dieta` (
  `idhistorial_dieta` int(10) unsigned NOT NULL auto_increment,
  `dieta_iddieta` int(10) unsigned NOT NULL,
  `alimentos_idalimentos` int(10) unsigned NOT NULL,
  `comida_hora_fecha` timestamp NULL default NULL,
  `numero_porciones` int(10) unsigned default NULL,
  PRIMARY KEY  (`idhistorial_dieta`),
  KEY `historial_dieta_FKIndex1` (`alimentos_idalimentos`),
  KEY `historial_dieta_FKIndex2` (`dieta_iddieta`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `historial_dieta`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `seguimiento_pesonal`
-- 

CREATE TABLE `seguimiento_pesonal` (
  `idhistorial_pesonal` int(10) unsigned NOT NULL auto_increment,
  `usuario_idUSUARIO` int(10) unsigned NOT NULL,
  `tipo_variable` varchar(255) default NULL,
  `fecha` timestamp NULL default NULL,
  `valor` int(10) unsigned default NULL,
  PRIMARY KEY  (`idhistorial_pesonal`),
  KEY `seguimiento_pesonal_FKIndex1` (`usuario_idUSUARIO`),
  KEY `seguimiento_pesonal_FKIndex2` (`usuario_idUSUARIO`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `seguimiento_pesonal`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `usuario`
-- 

CREATE TABLE `usuario` (
  `idUSUARIO` int(10) unsigned NOT NULL auto_increment,
  `nombre` varchar(100) default NULL,
  `pass` varchar(50) default NULL,
  `nickname` varchar(50) default NULL,
  `email` varchar(100) default NULL,
  `sexo` varchar(10) default NULL,
  `edad` int(10) unsigned default NULL,
  `pais_residencia` varchar(255) default NULL,
  `estatura` int(10) unsigned default NULL,
  PRIMARY KEY  (`idUSUARIO`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `usuario`
-- 

