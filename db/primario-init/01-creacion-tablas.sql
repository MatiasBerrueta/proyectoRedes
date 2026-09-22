CREATE DATABASE IF NOT EXISTS Voxel_Hosting;
USE Voxel_Hosting;

CREATE TABLE USUARIO (
id_usuario INT PRIMARY KEY AUTO_INCREMENT,
nombre VARCHAR(1000),
email VARCHAR(100) UNIQUE NOT NULL,
contrasena VARCHAR(1000) NOT NULL,
rol ENUM('ADMIN', 'CLIENTE'),
estado ENUM('ACTIVO', 'INACTIVO') DEFAULT 'ACTIVO',
pais VARCHAR(50),
client_key VARCHAR(255),
id_pterodactyl VARCHAR(100)
);

CREATE TABLE PLAN (
id_plan INT PRIMARY KEY AUTO_INCREMENT,
nombre VARCHAR(1000),
descripcion TEXT,
costo DECIMAL(10,2),
max_jugadores INT,
duracion INT,
id_contrato INT,
ram_gb INT,
prioridad ENUM('BAJA', 'MEDIA', 'ALTA'),
soporte_24_7 BOOLEAN,
tag ENUM('MAS_VENDIDO', 'MEJOR_PRECIO', 'RECOMENDADO', 'NINGUNO')
);

CREATE TABLE ASIGNA (
id_usuario INT,
id_plan INT,
fecha_contratacion DATE,
PRIMARY KEY(id_usuario, id_plan),
FOREIGN KEY (id_usuario) REFERENCES USUARIO(id_usuario),
FOREIGN KEY (id_plan) REFERENCES PLAN(id_plan)
);

CREATE TABLE HISTORIAL_PAGO (
id_pago INT PRIMARY KEY AUTO_INCREMENT,
metodo VARCHAR(50),
monto DECIMAL(10,2),
fecha_pago DATE,
estado ENUM('PENDIENTE', 'CONFIRMADO'),
id_usuario INT,
FOREIGN KEY (id_usuario) REFERENCES USUARIO(id_usuario)
);

CREATE TABLE TICKET (
id_ticket INT PRIMARY KEY AUTO_INCREMENT,
asunto VARCHAR(100),
descripcion TEXT,
fecha_soporte DATE,
estado ENUM('ABIERTO', 'CERRADO'),
id_usuario INT,
FOREIGN KEY (id_usuario) REFERENCES USUARIO(id_usuario)
);

CREATE TABLE JUEGO (
  id_juego INT AUTO_INCREMENT,
  nest_id INT NOT NULL,
  nombre VARCHAR(100) NOT NULL,
  descripcion VARCHAR(255) DEFAULT NULL,
  imagen VARCHAR(255) DEFAULT NULL,
  estado ENUM('ACTIVO', 'INACTIVO') DEFAULT 'ACTIVO',
  PRIMARY KEY (id_juego),
  UNIQUE KEY unique_nest_id (nest_id)
);

CREATE TABLE VARIACION_JUEGO (
  id_variacion INT AUTO_INCREMENT,
  id_juego INT NOT NULL,
  nombre_variacion VARCHAR(100) NOT NULL,
  descripcion_variacion VARCHAR(255),
  egg_id INT NOT NULL,
  PRIMARY KEY (id_variacion),
  UNIQUE KEY unique_egg_id (egg_id),
  FOREIGN KEY (id_juego) REFERENCES JUEGO(id_juego) ON DELETE CASCADE
);

CREATE TABLE SERVIDOR (
  id_servidor INT AUTO_INCREMENT,
  nombre VARCHAR(1000),
  descripcion VARCHAR(200),
  version_juego VARCHAR(50),
  dominio VARCHAR(100),
  puerto INT,
  estado ENUM('REINICIANDO', 'ACTIVO', 'DETENIDO', 'PARANDO'),
  id_pterodactyl VARCHAR(100),
  id_variacion INT,
  id_usuario INT,
  PRIMARY KEY (id_servidor),
  FOREIGN KEY (id_variacion) REFERENCES VARIACION_JUEGO(id_variacion),
  FOREIGN KEY (id_usuario) REFERENCES USUARIO(id_usuario)
);

CREATE TABLE LOG (
id_log INT PRIMARY KEY AUTO_INCREMENT,
tipo VARCHAR(50),
mensaje TEXT,
fecha DATETIME,
id_servidor INT,
FOREIGN KEY (id_servidor) REFERENCES SERVIDOR(id_servidor)
);

CREATE TABLE REGLA_AUTOMATICA (
id_regla INT PRIMARY KEY AUTO_INCREMENT,
condicion TEXT,
accion TEXT,
id_servidor INT,
FOREIGN KEY (id_servidor) REFERENCES SERVIDOR(id_servidor)
);

CREATE VIEW VISTA_USUARIO_ACTIVO AS
SELECT id_usuario, nombre, email, pais
FROM USUARIO
WHERE estado = 'ACTIVO';

CREATE VIEW VISTA_USUARIO_PLAN AS SELECT
U.id_usuario,
U.nombre AS nombre_usuario,
U.email,
P.nombre AS nombre_plan,
P.costo,
A.fecha_contratacion
FROM USUARIO U
JOIN ASIGNA A ON U.id_usuario = A.id_usuario
JOIN PLAN P ON A.id_plan = P.id_plan;

CREATE VIEW VISTA_PAGO_PENDIENTE AS SELECT 
H.id_pago,
U.nombre AS usuario,
H.monto,
H.fecha_pago,
H.metodo
FROM HISTORIAL_PAGO H
JOIN USUARIO U ON H.id_usuario = U.id_usuario
WHERE H.estado = 'PENDIENTE';

CREATE VIEW VISTA_HISTORIAL_PAGO AS SELECT
H.id_pago,
U.nombre AS usuario,
H.metodo,
H.monto,
H.fecha_pago,
H.estado
FROM HISTORIAL_PAGO H 
JOIN USUARIO U ON H.id_usuario = U.id_usuario;

CREATE VIEW VISTA_SERVIDOR_JUEGO AS 
SELECT 
    J.nombre AS juego,
    COUNT(S.id_servidor) AS cantidad_servidores
FROM JUEGO J
LEFT JOIN VARIACION_JUEGO V ON J.id_juego = V.id_juego
LEFT JOIN SERVIDOR S ON V.id_variacion = S.id_variacion
GROUP BY J.id_juego, J.nombre;

CREATE VIEW VISTA_TICKET_ABIERTO AS SELECT
T.id_ticket,
U.nombre AS usuario,
T.asunto,
T.descripcion,
T.fecha_soporte,
T.estado
FROM TICKET T
JOIN USUARIO U ON T.id_usuario = U.id_usuario
WHERE T.estado = 'ABIERTO';