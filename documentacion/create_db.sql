CREATE TABLE tedi_alimentos (
  idalimentos INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  tedi_dieta_iddieta INTEGER UNSIGNED NOT NULL,
  nombre INTEGER UNSIGNED NULL,
  porcion_tipo VARCHAR(255) NULL,
  porcion_gramos INTEGER UNSIGNED NULL,
  categoria VARCHAR(255) NULL,
  calorias_porcion INTEGER UNSIGNED NULL,
  es_bebida INTEGER UNSIGNED NULL,
  PRIMARY KEY(idalimentos),
  INDEX tedi_alimentos_FKIndex1(tedi_dieta_iddieta)
);

CREATE TABLE tedi_dieta (
  iddieta INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  tedi_usuario_idUSUARIO INTEGER UNSIGNED NOT NULL,
  numero_alimentacion INTEGER UNSIGNED NULL,
  tipo_dieta INTEGER UNSIGNED NULL,
  PRIMARY KEY(iddieta),
  INDEX tedi_dieta_FKIndex1(tedi_usuario_idUSUARIO)
);

CREATE TABLE tedi_historial_dieta (
  idhistorial_dieta INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  tedi_dieta_iddieta INTEGER UNSIGNED NOT NULL,
  tedi_alimentos_idalimentos INTEGER UNSIGNED NOT NULL,
  comida_hora_fecha TIMESTAMP NULL,
  numero_porciones INTEGER UNSIGNED NULL,
  PRIMARY KEY(idhistorial_dieta),
  INDEX tedi_historial_dieta_FKIndex1(tedi_alimentos_idalimentos),
  INDEX tedi_historial_dieta_FKIndex2(tedi_dieta_iddieta)
);

CREATE TABLE tedi_seguimiento_pesonal (
  idhistorial_pesonal INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  tedi_usuario_idUSUARIO INTEGER UNSIGNED NOT NULL,
  tipo_variable VARCHAR(255) NULL,
  fecha TIMESTAMP NULL,
  valor INTEGER UNSIGNED NULL,
  PRIMARY KEY(idhistorial_pesonal),
  INDEX tedi_seguimiento_pesonal_FKIndex1(tedi_usuario_idUSUARIO)
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

