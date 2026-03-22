INSERT INTO USUARIO (nombre, email, contrasena, rol, estado, pais)  VALUES 
-- Contrasena: 12345
('Juan Pérez', 'juanp@example.com', '$2y$10$YnqqUnsGq5ow2rh5K3p5aO9lMmLBdleWKCpGJN.LUJbp7ccj9Ytdi', 'CLIENTE', 'ACTIVO',  'Uruguay'), 
('María López', 'marial@example.com', 'abcde', 'CLIENTE',  
'INACTIVO', 'Argentina'), 
('Carlos Gómez', 'cgomez@example.com', 'pass123', 'ADMIN',  'ACTIVO', 'Chile'); 

INSERT INTO PLAN (nombre, costo, max_jugadores, duracion)  VALUES 
('Básico', 10.00, 10, 30), 
('Premium', 25.00, 25, 60), 
('Ultimate', 50.00, 50, 90); 

INSERT INTO VIDEOJUEGO (nombre, descripcion, logo) VALUES 
('Minecraft', 'Juego de construcción con bloques', 'minecraft.png'),
('CS:GO', 'Shooter en primera persona competitivo', 'csgo.png'),
('Valorant', 'Juego táctico de disparos 5v5', 'valorant.png'); 

INSERT INTO SERVIDOR (nombre, dominio, puerto, region, estado,  id_videojuego, version_juego) VALUES 
('Servidor_MC_1', 'mc1.voxelhost.com', 25565, 'US-East', 'ACTIVO',  1, 1), 
('Servidor_CS_1', 'cs1.voxelhost.com', 27015, 'EU-West', 'ACTIVO', 2,  1), 
('Servidor_VAL_1', 'val1.voxelhost.com', 30120, 'SA', 'REINICIANDO',  3, 1); 

INSERT INTO ASIGNA (id_usuario, id_plan, fecha_contratacion)  VALUES 
(1, 1, '2025-10-01'), 
(2, 2, '2025-10-05'), 
(3, 3, '2025-10-10'); 

INSERT INTO HISTORIAL_PAGO (metodo, monto, fecha_pago, estado,  id_usuario) VALUES 
('Tarjeta', 10.00, '2025-10-01', 'CONFIRMADO', 1), 
('PayPal', 25.00, '2025-10-06', 'PENDIENTE', 2), 
('Tarjeta', 50.00, '2025-10-12', 'CONFIRMADO', 3); 

INSERT INTO TICKET (asunto, descripcion, fecha_soporte, estado,  id_usuario) VALUES 
('Error de conexión', 'No puedo ingresar al servidor', '2025-10-15',  'ABIERTO', 1), 
('Problema de pago', 'Pago pendiente sin confirmar', '2025-10-16',  'CERRADO', 2), 
('Consulta general', '¿Cuántos servidores puedo tener?', '2025-10- 18', 'ABIERTO', 3); 

INSERT INTO REGLA_AUTOMATICA (condicion, accion, id_servidor)  VALUES 
('CPU > 80%', 'Reiniciar servidor', 1), 
('Jugadores = 0 por 1h', 'Apagar servidor', 2), 
('Error crítico detectado', 'Enviar alerta al admin', 3); 

INSERT INTO LOG (tipo, mensaje, fecha, id_servidor) VALUES 
('Pago', 'Nuevo pago registrado para usuario 1', '2025-10-01  14:00:00', NULL), 
('Servidor', 'Servidor 3 reiniciado correctamente', '2025-10-12  15:00:00', 3), 
('Usuario', 'El usuario María López fue inactivado', '2025-10-06  10:00:00', NULL); 
