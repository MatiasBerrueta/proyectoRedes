USE Voxel_Hosting;

INSERT INTO USUARIO
(nombre, email, contrasena, rol, estado, pais)
VALUES
-- Contrasena: 12345
('Juan Pérez', 'juanp@example.com',
 '$2y$10$YnqqUnsGq5ow2rh5K3p5aO9lMmLBdleWKCpGJN.LUJbp7ccj9Ytdi',
 'CLIENTE', 'ACTIVO', 'Uruguay'),

('María López', 'marial@example.com',
 'abcde',
 'CLIENTE', 'INACTIVO', 'Argentina'),

('Carlos Gómez', 'cgomez@example.com',
 'pass123',
 'ADMIN', 'ACTIVO', 'Chile');

INSERT INTO PLAN
(nombre, descripcion, costo, max_jugadores, duracion, ram_gb, prioridad, soporte_24_7, tag)
VALUES
('Básico',
 'Plan inicial para servidores pequeños.',
 10.00, 10, 30, 2, 'BAJA', FALSE, 'MEJOR_PRECIO'),

('Premium',
 'Plan intermedio para servidores con mayor capacidad.',
 25.00, 25, 60, 4, 'MEDIA', TRUE, 'MAS_VENDIDO'),

('Ultimate',
 'Plan de mayor capacidad para servidores grandes.',
 50.00, 50, 90, 8, 'ALTA', TRUE, 'RECOMENDADO');

INSERT INTO VIDEOJUEGO
(egg_id, nest_id, nombre, nombre_grupo, descripcion, imagen, estado)
VALUES
(1, 1,
 'Minecraft',
 'Minecraft',
 'Juego de construcción con bloques.',
 'minecraft.png',
 'ACTIVO'),

(2, 2,
 'CS:GO',
 'Counter-Strike',
 'Shooter en primera persona competitivo.',
 'csgo.png',
 'ACTIVO'),

(3, 3,
 'Valorant',
 'Valorant',
 'Juego táctico de disparos 5v5.',
 'valorant.png',
 'ACTIVO');

INSERT INTO SERVIDOR
(nombre, descripcion, version_juego, dominio, puerto, estado,
 id_pterodactyl, id_videojuego, id_usuario)
VALUES
('Servidor_MC_1',
 'Servidor de Minecraft de prueba.',
 '1.21.1',
 'mc1.voxelhost.com',
 25565,
 'ACTIVO',
 1,
 1,
 1),

('Servidor_CS_1',
 'Servidor de Counter-Strike de prueba.',
 '1.6',
 'cs1.voxelhost.com',
 27015,
 'ACTIVO',
 2,
 2,
 2),

('Servidor_VAL_1',
 'Servidor de Valorant de prueba.',
 '1.0',
 'val1.voxelhost.com',
 30120,
 'REINICIANDO',
 3,
 3,
 3);

INSERT INTO ASIGNA
(id_usuario, id_plan, fecha_contratacion)
VALUES
(1, 1, '2025-10-01'),
(2, 2, '2025-10-05'),
(3, 3, '2025-10-10');

INSERT INTO HISTORIAL_PAGO
(metodo, monto, fecha_pago, estado, id_usuario)
VALUES
('Tarjeta', 10.00, '2025-10-01', 'CONFIRMADO', 1),
('PayPal', 25.00, '2025-10-06', 'PENDIENTE', 2),
('Tarjeta', 50.00, '2025-10-12', 'CONFIRMADO', 3);

INSERT INTO TICKET
(asunto, descripcion, fecha_soporte, estado, id_usuario)
VALUES
('Error de conexión',
 'No puedo ingresar al servidor.',
 '2025-10-15',
 'ABIERTO',
 1),

('Problema de pago',
 'Pago pendiente sin confirmar.',
 '2025-10-16',
 'CERRADO',
 2),

('Consulta general',
 '¿Cuántos servidores puedo tener?',
 '2025-10-18',
 'ABIERTO',
 3);

INSERT INTO REGLA_AUTOMATICA
(condicion, accion, id_servidor)
VALUES
('CPU > 80%',
 'Reiniciar servidor',
 1),

('Jugadores = 0 por 1h',
 'Apagar servidor',
 2),

('Error crítico detectado',
 'Enviar alerta al admin',
 3);

INSERT INTO LOG
(tipo, mensaje, fecha, id_servidor)
VALUES
('Pago',
 'Nuevo pago registrado para usuario 1',
 '2025-10-01 14:00:00',
 NULL),

('Servidor',
 'Servidor 3 reiniciado correctamente',
 '2025-10-12 15:00:00',
 3),

('Usuario',
 'El usuario María López fue inactivado',
 '2025-10-06 10:00:00',
 NULL);
