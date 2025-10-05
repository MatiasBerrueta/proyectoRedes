USE voxelHosting;

-- CREACION DE TABLAS --
CREATE TABLE usuario (
  id INT AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(100) UNIQUE NOT NULL,
  contrasena VARCHAR(12) NOT NULL,
  tipo ENUM ('ADMIN', 'CLIENTE') NOT NULL
);
CREATE TABLE cliente (
  id_usuario INT PRIMARY KEY,
  telefono VARCHAR(20),
  FOREIGN KEY (id_usuario)
  REFERENCES usuario(id)
);
CREATE TABLE administrador (
  id_usuario INT PRIMARY KEY,
  -- posibles atributos --
  FOREIGN KEY (id_usuario)
  REFERENCES usuario(id)
);
CREATE TABLE plan (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(20) NOT NULL,
  costo DECIMAL(10,2) NOT NULL,
  max_jugadores INT NOT NULL,
  duracion INT NOT NULL -- en meses --
);
CREATE TABLE cliente_plan (
  id_cliente INT,
  id_plan INT,
  PRIMARY KEY (id_cliente, id_plan),
  FOREIGN KEY (id_cliente)
  REFERENCES cliente(id_usuario),
  FOREIGN KEY (id_plan) REFERENCES
  plan(id)
);
CREATE TABLE servidor (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL,
  puerto INT NOT NULL,
  dominio VARCHAR(100) NOT NULL
);
  CREATE TABLE plan_servidor (
  id INT AUTO_INCREMENT PRIMARY KEY,
  id_plan INT NOT NULL,
  id_servidor INT NOT NULL,
  fecha_asignacion DATE NOT NULL, -- cuando se asigno el plan --
  estado ENUM('ACTIVO','INACTIVO') DEFAULT 'ACTIVO',
  FOREIGN KEY (id_plan) REFERENCES plan(id),
  FOREIGN KEY (id_servidor) REFERENCES servidor(id)
);
-- CREACION DE TABLAS --

-- PROCEDIMIENTOS ALMACENADOS --
DELIMITER // 
CREATE PROCEDURE insertar_cliente(IN p_email VARCHAR(100), IN p_contrasena VARCHAR(100)) 
BEGIN 
    INSERT INTO usuario (email, contrasena) VALUES (p_email, p_contrasena); 
    INSERT INTO cliente (id_usuario) VALUES (LAST_INSERT_ID());
END // 
DELIMITER; 
 
DELIMITER // 
CREATE PROCEDURE asignar_plan(IN p_cliente INT, IN p_id_plan INT) 
BEGIN 
    INSERT INTO cliente_plan (id_cliente, id_plan) VALUES (p_cliente, p_id_plan); 
END // 
DELIMITER; 
-- PROCEDIMIENTOS ALMACENADOS --

-- DATOS INICIALES --
INSERT INTO usuario (email, contrasena) VALUES ('admin@mail.com','$2y$10$TAKQqO5hD3rPbvZCguvHh.tSi7HkP8T4eDjXg5NtRX6bABuLxK4Pu'); 
INSERT INTO administrador (id_usuario) VALUES (1); 

CALL insertar_cliente('cliente@mail.com','$2y$10$jgkRqMzgDyLrQULED32zP.6.HLQzhCtsYm22mrWWOA4Q8TU1AHH0S', '099123456');
 
INSERT INTO plan (nombre, costo, max_jugadores, duracion, fecha_inicio)
VALUES ('Voxel Essential', 120.00, 20, 12, '2025-01-01'); 
 
INSERT INTO servidor (nombre, dominio, puerto) 
VALUES ('Srv1','srv1.hosting.com',25565);

CALL asignar_plan(2, 1);
-- DATOS INICIALES --