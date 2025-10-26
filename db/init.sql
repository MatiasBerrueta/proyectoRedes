CREATE TABLE USUARIO (
id_usuario INT PRIMARY KEY AUTO_INCREMENT,
nombre VARCHAR(1000),
email VARCHAR(100) UNIQUE NOT NULL,
contrasena VARCHAR(1000) NOT NULL,
rol ENUM('ADMIN', 'CLIENTE'),
estado ENUM('ACTIVO', 'INACTIVO'),
pais VARCHAR(50)
);

CREATE TABLE PLAN (
id_plan INT PRIMARY KEY AUTO_INCREMENT,
nombre VARCHAR(1000),
costo DECIMAL(10,2),
max_jugadores INT,
duracion INT,
id_contrato INT
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

CREATE TABLE VIDEOJUEGO (
id_videojuego INT PRIMARY KEY AUTO_INCREMENT,
nombre VARCHAR(1000),
descripcion TEXT,
version VARCHAR(50),
logo VARCHAR(100)
);

CREATE TABLE SERVIDOR (
id_servidor INT PRIMARY KEY AUTO_INCREMENT,
nombre VARCHAR(1000),
dominio VARCHAR(100),
puerto INT,
estado ENUM('REINICIANDO', 'ACTIVO'),
id_videojuego INT,
FOREIGN KEY (id_videojuego) REFERENCES VIDEOJUEGO(id_videojuego)
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

CREATE VIEW VISTA_SERVIDOR_VIDEOJUEGO AS SELECT 
V.nombre AS videojuego,
COUNT(S.id_servidor) AS cantidad_servidores
FROM VIDEOJUEGO V
LEFT JOIN SERVIDOR S ON V.id_videojuego = S.id_videojuego
GROUP BY V.nombre;

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

DELIMITER //
CREATE PROCEDURE AGREGAR_USUARIO (
IN p_nombre VARCHAR(1000),
IN p_email VARCHAR(100),
IN p_contrasena VARCHAR(1000),
IN p_pais VARCHAR(50)
)
BEGIN
INSERT INTO USUARIO (nombre, email, contrasena, rol, estado, pais)
VALUES (p_nombre, p_email, p_contrasena, 'CLIENTE', 'ACTIVO', p_pais);
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE ACTUALIZAR_ROL_USUARIO (
IN p_id_usuario INT,
IN p_nuevo_rol VARCHAR(50)
)
BEGIN 
UPDATE USUARIO
SET rol = p_nuevo_rol
WHERE id_usuario = p_id_usuario;
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE ACTUALIZAR_USUARIO (
IN p_id_usuario INT,
IN p_nombre VARCHAR(1000),
IN p_email VARCHAR(100),
IN p_pais VARCHAR(50)
)
BEGIN
UPDATE USUARIO
SET nombre = p_nombre,
email = p_email,
pais = p_pais
WHERE id_usuario = p_id_usuario;
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE ACTUALIZAR_ESTADO_USUARIO (
IN p_id_usuario INT,
IN p_nuevo_estado VARCHAR(50)
)
BEGIN
UPDATE USUARIO
SET estado = p_nuevo_estado
WHERE id_usuario = p_id_usuario;
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE CONSULTAR_USUARIO_ACTIVO ()
BEGIN
SELECT id_usuario, nombre, email, pais
FROM USUARIO
WHERE estado = 'ACTIVO';
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE ASIGNAR_PLAN_USUARIO (
IN p_id_usuario INT,
IN p_id_plan INT
)
BEGIN
INSERT INTO ASIGNA (id_usuario, id_plan, fecha_contratacion)
VALUES (p_id_usuario, p_id_plan, CURDATE());
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE REGISTRAR_PAGO (
IN p_metodo VARCHAR(50),
IN p_monto DECIMAL(10,2),
IN p_id_usuario INT
)
BEGIN
INSERT INTO HISTORIAL_PAGO
(metodo, monto, fecha_pago, estado, id_usuario)
VALUES (p_metodo, p_monto, CURDATE(), 'PENDIENTE', p_id_usuario);
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE CONFIRMAR_PAGO (
IN p_id_pago INT
)
BEGIN
UPDATE HISTORIAL_PAGO
SET estado = 'CONFIRMADO'
WHERE id_pago = p_id_pago;
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE OBTENER_PAGO_PENDIENTE ()
BEGIN
SELECT 
H.id_pago,
U.nombre AS usuario,
H.monto,
H.fecha_pago,
H.metodo
FROM HISTORIAL_PAGO H
JOIN USUARIO U ON H.id_usuario = U.id_usuario
WHERE H.estado = 'PENDIENTE';
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE TOTAL_PAGO_USUARIO (
IN p_id_usuario INT
)
BEGIN
SELECT
U.nombre,
SUM(H.monto) AS total_pagado
FROM HISTORIAL_PAGO H JOIN USUARIO U ON H.id_usuario = U.id_usuario
WHERE H.id_usuario = p_id_usuario
GROUP BY U.nombre;
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE RESUMEN_PAGO_POR_USUARIO ()
BEGIN
SELECT 
U.id_usuario,
U.nombre,
COUNT(H.id_pago) AS cantidad_pagos,
SUM(H.monto) AS total_pagado
FROM USUARIO U
JOIN HISTORIAL_PAGO H ON U.id_usuario = H.id_usuario
WHERE H.estado = 'CONFIRMADO'
GROUP BY U.id_usuario, U.nombre;
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE CREAR_SERVIDOR (
IN p_nombre VARCHAR(1000),
IN p_dominio VARCHAR(100),
IN p_puerto INT,
IN p_estado VARCHAR(50),
IN p_id_videojuego INT
)
BEGIN
INSERT INTO SERVIDOR (nombre, dominio, puerto, estado, id_videojuego)
VALUES (p_nombre, p_dominio, p_puerto, p_estado, p_id_videojuego);
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE REINICIAR_SERVIDOR (
IN p_id_servidor INT
)
BEGIN
UPDATE SERVIDOR
SET estado = 'REINICIANDO'
WHERE id_servidor = p_id_servidor;
INSERT INTO LOG (tipo, mensaje, fecha, id_servidor)
VALUES ('Mantenimiento', 'Servidor reiniciado correctamente', NOW(), p_id_servidor);
UPDATE SERVIDOR
SET estado = 'ACTIVO'
WHERE id_servidor = p_id_servidor;
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE ACTUALIZAR_SERVIDOR(
IN p_id_servidor INT,
IN p_nombre VARCHAR(1000),
IN p_dominio VARCHAR(100),
IN p_puerto INT
)
BEGIN
UPDATE SERVIDOR
SET nombre = p_nombre,
    dominio = p_dominio,
    puerto = p_puerto
WHERE id_servidor = p_id_servidor;
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE ELIMINAR_SERVIDOR(
IN p_id_servidor INT
)
BEGIN
DELETE FROM SERVIDOR
WHERE id_servidor = p_id_servidor;
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE SERVIDOR_POR_VIDEOJUEGO ()
BEGIN
SELECT 
V.nombre AS videojuego,
COUNT(S.id_servidor) AS cantidad_servidores
FROM VIDEOJUEGO V
LEFT JOIN SERVIDOR S ON V.id_videojuego = S.id_videojuego
GROUP BY V.nombre;
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE CREAR_TICKET_ (
IN p_asunto VARCHAR(100),
IN p_descripcion TEXT,
IN p_id_usuario INT
)
BEGIN
INSERT INTO TICKET (asunto, descripcion, fecha_soporte, estado, id_usuario)
VALUES (p_asunto, p_descripcion, CURDATE(), 'ABIERTO', p_id_usuario);
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE CERRAR_TICKET (
IN p_id_ticket INT
)
BEGIN
UPDATE TICKET
SET estado = 'CERRADO'
WHERE id_ticket = p_id_ticket;
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE TICKET_POR_USUARIO(
IN p_id_usuario INT
)
BEGIN
SELECT *
FROM TICKET
WHERE id_usuario = p_id_usuario;
END //
DELIMITER ;

DELIMITER //
CREATE TRIGGER TRG_PAGO_INSERT
AFTER INSERT ON HISTORIAL_PAGO
FOR EACH ROW
BEGIN
INSERT INTO LOG (tipo, mensaje, fecha, id_servidor)
VALUES ('Pago', CONCAT('Nuevo pago registrado para usuario ID ', NEW.id_usuario), NOW(), NULL);
END //
DELIMITER ;

DELIMITER //
CREATE TRIGGER TRG_USUARIO_INACTIVO
AFTER UPDATE ON USUARIO
FOR EACH ROW
BEGIN
IF NEW.estado = 'INACTIVO' THEN
INSERT INTO LOG (tipo, mensaje, fecha, id_servidor)
VALUES ('Usuario', CONCAT('El usuario ', NEW.nombre, ' ha sido marcado como inactivo.'), NOW(), NULL);
END IF;
END //
DELIMITER ;

DELIMITER //
CREATE TRIGGER TRG_TICKET_DELETE
AFTER DELETE ON TICKET
FOR EACH ROW
BEGIN
INSERT INTO LOG (tipo, mensaje, fecha, id_servidor)
VALUES ('Ticket', CONCAT('Ticket ID ', OLD.id_ticket, ' eliminado del sistema.'), NOW(), NULL);
END //
DELIMITER ;

DELIMITER //
CREATE TRIGGER TRG_SERVIDOR_REINICIO
AFTER UPDATE ON SERVIDOR
FOR EACH ROW
BEGIN
IF NEW.estado = 'REINICIANDO' THEN
INSERT INTO LOG (tipo, mensaje, fecha, id_servidor)
VALUES ('Mantenimiento', CONCAT('Servidor ', NEW.nombre, ' en proceso de reinicio'), NOW(), NEW.id_servidor);
END IF;
END //
DELIMITER ;

DELIMITER //
CREATE TRIGGER TRG_TICKET_CERRADO
AFTER UPDATE ON TICKET
FOR EACH ROW
BEGIN
IF NEW.estado = 'CERRADO' THEN
INSERT INTO LOG (tipo, mensaje, fecha, id_servidor)
VALUES ('Soporte', CONCAT('Ticket ID ', NEW.id_ticket, ' cerrado por usuario ', NEW.id_usuario), NOW(), NULL);
END IF;
END //
DELIMITER ;

CREATE ROLE 'ADMIN';
CREATE ROLE 'CLIENTE';

CREATE USER 'admin'@'%' IDENTIFIED BY 'admin123';
GRANT 'ADMIN' TO 'admin'@'%';
CREATE USER 'cliente'@'%' IDENTIFIED BY 'cliente123';
GRANT 'CLIENTE' TO 'cliente'@'%';

GRANT ALL PRIVILEGES ON Voxel_Hosting.* TO 'ADMIN'; 
-- GRANT EXECUTE ON PROCEDURE Voxel_Hosting.AGREGAR_USUARIO TO 'CLIENTE';
-- GRANT EXECUTE ON PROCEDURE Voxel_Hosting.ACTUALIZAR_USUARIO TO 'CLIENTE';
-- GRANT EXECUTE ON PROCEDURE Voxel_Hosting.ELIMINAR_USUARIO TO 'CLIENTE';
-- GRANT EXECUTE ON PROCEDURE Voxel_Hosting.CONSULTAR_USUARIO_ACTIVO TO 'CLIENTE';
-- GRANT EXECUTE ON PROCEDURE Voxel_Hosting.ASIGNAR_PLAN_USUARIO TO 'CLIENTE';
-- GRANT EXECUTE ON PROCEDURE Voxel_Hosting.REGISTRAR_PAGO TO 'CLIENTE';
-- GRANT EXECUTE ON PROCEDURE Voxel_Hosting.CONFIRMAR_PAGO TO 'CLIENTE';
-- GRANT EXECUTE ON PROCEDURE Voxel_Hosting.OBTENER_PAGO_PENDIENTE TO 'CLIENTE';
-- GRANT EXECUTE ON PROCEDURE Voxel_Hosting.TOTAL_PAGO_USUARIO TO 'CLIENTE';
-- GRANT EXECUTE ON PROCEDURE Voxel_Hosting.CREAR_SERVIDOR TO 'CLIENTE';
-- GRANT EXECUTE ON PROCEDURE Voxel_Hosting.REINICIAR_SERVIDOR TO 'CLIENTE';
-- GRANT EXECUTE ON PROCEDURE Voxel_Hosting.ACTUALIZAR_SERVIDOR TO 'CLIENTE';
-- GRANT EXECUTE ON PROCEDURE Voxel_Hosting.ELIMINAR_SERVIDOR TO 'CLIENTE';
-- GRANT EXECUTE ON PROCEDURE Voxel_Hosting.CREAR_TICKET TO 'CLIENTE';
-- GRANT EXECUTE ON PROCEDURE Voxel_Hosting.CERRAR_TICKET TO 'CLIENTE';
-- GRANT EXECUTE ON PROCEDURE Voxel_Hosting.TICKET_POR_USUARIO TO 'CLIENTE';