CREATE TABLE tedi_alimentos (
  idalimentos INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  nombre VARCHAR(100) NULL,
  porcion_tipo VARCHAR(255) NULL,
  porcion_gramos INTEGER UNSIGNED NULL,
  categoria VARCHAR(255) NULL,
  calorias_porcion INTEGER UNSIGNED NULL,
  es_bebida INTEGER UNSIGNED NULL,
  unidad_medida VARCHAR(30) NULL,
  porcion_popular VARCHAR(100) NULL,
  PRIMARY KEY(idalimentos)
);

CREATE TABLE tedi_dieta (
  iddieta INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  tedi_usuario_idUSUARIO INTEGER UNSIGNED NULL,
  numero_alimentacion INTEGER UNSIGNED NULL,
  tipo_dieta INTEGER UNSIGNED NULL,
  PRIMARY KEY(iddieta),
  INDEX dieta_FKIndex1(tedi_usuario_idUSUARIO)
);

CREATE TABLE tedi_historial_dieta (
  idhistorial_dieta INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  tedi_menu_idmenu INTEGER UNSIGNED NOT NULL,
  tedi_dieta_iddieta INTEGER UNSIGNED NULL,
  tedi_alimentos_idalimentos INTEGER UNSIGNED NULL,
  comida_hora_fecha TIMESTAMP NULL,
  numero_porciones INTEGER UNSIGNED NULL,
  PRIMARY KEY(idhistorial_dieta),
  INDEX historial_dieta_FKIndex1(tedi_alimentos_idalimentos),
  INDEX historial_dieta_FKIndex2(tedi_dieta_iddieta),
  INDEX tedi_historial_dieta_FKIndex3(tedi_menu_idmenu)
);

CREATE TABLE tedi_menu (
  idmenu INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  tedi_dieta_iddieta INTEGER UNSIGNED NULL,
  nombre_menu VARCHAR(100) NULL,
  tipo_menu VARCHAR(100) NULL,
  PRIMARY KEY(idmenu),
  INDEX tedi_menu_FKIndex1(tedi_dieta_iddieta)
);

CREATE TABLE tedi_menu_has_tedi_alimentos (
  tedi_menu_idmenu INTEGER UNSIGNED NOT NULL,
  tedi_alimentos_idalimentos INTEGER UNSIGNED NOT NULL,
  PRIMARY KEY(tedi_menu_idmenu, tedi_alimentos_idalimentos),
  INDEX tedi_menu_has_tedi_alimentos_FKIndex1(tedi_menu_idmenu),
  INDEX tedi_menu_has_tedi_alimentos_FKIndex2(tedi_alimentos_idalimentos)
);

CREATE TABLE tedi_seguimiento_pesonal (
  idhistorial_pesonal INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  tedi_usuario_idUSUARIO INTEGER UNSIGNED NOT NULL,
  nivel_actividad VARCHAR(50) NULL,
  calorias_reportadas INTEGER UNSIGNED NULL DEFAULT 0,
  peso INTEGER UNSIGNED NULL DEFAULT 0,
  fecha TIMESTAMP NULL,
  PRIMARY KEY(idhistorial_pesonal),
  INDEX seguimiento_pesonal_FKIndex1(tedi_usuario_idUSUARIO),
  INDEX seguimiento_pesonal_FKIndex2(tedi_usuario_idUSUARIO)
);

CREATE TABLE tedi_usuario (
  idUSUARIO INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  nombre VARCHAR(300) NULL,
  pass VARCHAR(50) NULL,
  nickname VARCHAR(50) NULL,
  email VARCHAR(200) NULL,
  sexo VARCHAR(10) NULL,
  edad INTEGER UNSIGNED NULL,
  pais_residencia VARCHAR(255) NULL,
  estatura INTEGER UNSIGNED NULL,
  PRIMARY KEY(idUSUARIO)
);


