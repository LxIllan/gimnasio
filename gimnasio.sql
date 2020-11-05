#DROP DATABASE gimnasio;
#CREATE DATABASE gimnasio;

CREATE TABLE gimnasio (
  idgimnasio smallint(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  nombre varchar(45) NOT NULL,
  dinero float(8,2) NOT NULL
);

INSERT INTO gimnasio (nombre, dinero) VALUES
('Cazadores', 1200.00);

CREATE TABLE membresia (
  idmembresia tinyint(1) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  membresia varchar(10) NOT NULL,
  costo float(6,2) NOT NULL
);

INSERT INTO membresia (idmembresia, membresia, costo) VALUES
(1, 'Mensual', 300.00),
(2, 'Trimestral', 750.00),
(3, 'Semestral', 1300.00),
(4, 'Anual', 2400.00),
(5, 'Semanal', 100.00);

CREATE TABLE tipo_producto (
  idtipo_producto tinyint(1) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  tipo_producto varchar(11) NOT NULL
);

INSERT INTO tipo_producto (idtipo_producto, tipo_producto) VALUES
  (1, 'Bebidas'),
  (2, 'Suplementos'),
  (3, 'Accesorios'),
  (4, 'Otros');

CREATE TABLE producto (
  idproducto int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  nombre varchar(45) NOT NULL,
  precio float(6,2) NOT NULL,
  contenido varchar(15) DEFAULT NULL,
  num_piezas tinyint(3) NOT NULL,
  idtipo_producto tinyint(2) NOT NULL,
  FOREIGN KEY (idtipo_producto)
    REFERENCES tipo_producto (idtipo_producto) 
    ON DELETE NO ACTION ON UPDATE CASCADE
);

INSERT INTO producto (idproducto, nombre, precio, contenido, num_piezas, idtipo_producto) VALUES
(1, 'Visita', 30.00, '', 1, 4);

CREATE TABLE retiro_efectivo (
  idretiro int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  monto float(6,2) NOT NULL,
  fecha date NOT NULL,
  justificacion varchar(100) NOT NULL
);

CREATE TABLE sexo (
  idsexo tinyint(1) NOT NULL PRIMARY KEY,
  sexo varchar(10) NOT NULL
);

INSERT INTO sexo (idsexo, sexo) VALUES  
  (1, 'Femenino'),
  (2, 'Másculino');

CREATE TABLE socio (
  idsocio int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  nombre_pila varchar(45) NOT NULL,
  apellido1 varchar(30) NOT NULL,
  apellido2 varchar(30) DEFAULT NULL,
  fecha_nacimiento date NOT NULL,
  idsexo tinyint(1) NOT NULL,
  peso float(4, 2) NOT NULL,
  estatura float(4, 2) NOT NULL,
  lesion_abdomen tinyint(1) NOT NULL,
  lesion_brazos tinyint(1) NOT NULL,
  lesion_espalda tinyint(1) NOT NULL,
  lesion_hombro tinyint(1) NOT NULL,
  lesion_pecho tinyint(1) NOT NULL,
  lesion_piernas tinyint(1) NOT NULL,
  correo_electronico varchar(50) NOT NULL,
  ruta_fotografia varchar(100) NOT NULL,
  fecha_inscripcion date NOT NULL,
  ultima_asistencia date NOT NULL,
  dias_entrenando smallint(5) NOT NULL,
  fecha_fin_membresia date NOT NULL,
  oculto tinyint(1) NOT NULL DEFAULT '0',
  idmembresia tinyint(1) NOT NULL,
  FOREIGN KEY (idmembresia)
    REFERENCES membresia (idmembresia) 
    ON DELETE NO ACTION ON UPDATE CASCADA
  FOREIGN KEY (idsexo)
    REFERENCES sexo (idsexo) 
    ON DELETE NO ACTION ON UPDATE CASCADA
);

CREATE TABLE usuario (
  idusuario int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  nombre_pila varchar(45) NOT NULL,
  apellido1 varchar(30) NOT NULL,
  apellido2 varchar(30) DEFAULT NULL,
  correo_electronico varchar(50) NOT NULL,
  telefono varchar(20) NOT NULL,
  domicilio varchar(50) NOT NULL,
  clave char(40) NOT NULL,
  ruta_fotografia varchar(100) NOT NULL,
  root tinyint(1) NOT NULL DEFAULT '0',
  habilitado tinyint(1) NOT NULL DEFAULT '1',
  idgimnasio smallint(2) NOT NULL,
  FOREIGN KEY (idgimnasio)
    REFERENCES gimnasio (idgimnasio) 
    ON DELETE NO ACTION ON UPDATE CASCADE
);

INSERT INTO usuario (nombre_pila, apellido1, apellido2, correo_electronico, telefono, domicilio, clave, ruta_fotografia, root, habilitado, idgimnasio) VALUES
('Fernando', 'Illan', '', 'Fernando.Illan@damsoluciones.com', '33-23-35-64-95', 'Agustin Melgar #687', 'cef48cb4569d34364e0e86067efa14fbe9b4591e', 'img/Usuarios/IMG_1.jpg', 1, 1, 1);

CREATE TABLE venta_membresias (
  idventa_membresia int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  fecha date NOT NULL,
  idmembresia tinyint(2) NOT NULL,
  precio float(6,2) NOT NULL,
  idsocio int(11) NOT NULL,
  idusuario int(11) NOT NULL,
  FOREIGN KEY (idsocio)
    REFERENCES socio (idsocio) 
    ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (idusuario)
    REFERENCES usuario (idusuario) 
    ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE venta_productos (
  idventa_producto int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  fecha date NOT NULL,
  num_piezas tinyint(2) NOT NULL,
  precio float(6,2) NOT NULL,
  idproducto int(2) DEFAULT NULL,
  idusuario int(11) DEFAULT NULL,
  FOREIGN KEY (idproducto)
    REFERENCES producto (idproducto) 
    ON DELETE CASCADE  ON UPDATE CASCADE,
  FOREIGN KEY (idusuario)
    REFERENCES usuario (idusuario) 
    ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE parte_del_cuerpo (
  idparte_del_cuerpo tinyint(1) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  parte_del_cuerpo varchar(10) NOT NULL
);

INSERT INTO parte_del_cuerpo (parte_del_cuerpo) VALUES
  ('Abdomen'),
  ('Brazo'),
  ('Espalda'),
  ('Hombro'),
  ('Pecho'),
  ('Pierna');

CREATE TABLE musculo (
  idmusculo tinyint(1) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  musculo varchar(20) NOT NULL,
  idparte_del_cuerpo tinyint(1) NOT NULL,
  FOREIGN KEY (idparte_del_cuerpo)
    REFERENCES parte_del_cuerpo (idparte_del_cuerpo) 
    ON DELETE CASCADE  ON UPDATE CASCADE
);

INSERT INTO musculo (musculo, idparte_del_cuerpo) VALUES
  ('Abdomen', 1),
  ('Antebrazo', 2),
  ('Bícep', 2),
  ('Bícep femoral', 6),
  ('Cuadricep', 6),
  ('Espalda', 3),
  ('Femoral', 6),
  ('Hombro', 4),
  ('Glúteo', 6),
  ('Pantorrilla', 6),
  ('Pecho', 5),
  ('Trícep', 2);

CREATE TABLE ejercicio (
  idejercicio tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  nombre varchar(50) NOT NULL,
  series varchar(50) NOT NULL,
  ruta_fotografia varchar(100) NOT NULL,
  peso_principiante varchar(50) NOT NULL,
  peso_intermedio varchar(50) NOT NULL,
  peso_medio varchar(50) NOT NULL,
  peso_medioavanzado varchar(50) NOT NULL,
  peso_avanzado varchar(50) NOT NULL,
  idmusculo tinyint(1) NOT NULL,
  idsexo tinyint(1) NOT NULL,
  FOREIGN KEY (idmusculo)
    REFERENCES musculo (idmusculo) 
    ON DELETE CASCADE  ON UPDATE CASCADE,
  FOREIGN KEY (idsexo)
    REFERENCES sexo (idsexo) 
    ON DELETE CASCADE  ON UPDATE CASCADE
);