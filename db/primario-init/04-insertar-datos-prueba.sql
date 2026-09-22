USE Voxel_Hosting;
SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------
-- 1. TABLA: USUARIO
-- ---------------------------------------------------------
TRUNCATE TABLE USUARIO;

INSERT INTO USUARIO (id_usuario, nombre, email, contrasena, rol, estado, pais, client_key, id_pterodactyl) VALUES
-- ID 1 | Password: 12345
(1, 'Juan Pérez', 'juanp@example.com', '$2y$10$w09uA4yR5R4Zk3gG1y/vNuT7S.aYvR5O8R4L0d9K2.u9m5R6M7O.y', 'CLIENTE', 'ACTIVO', 'Uruguay', NULL, NULL),

-- ID 2 | Password: abcde
(2, 'María López', 'marial@example.com', '$2y$10$1Hk8L8N.w4d5A2c3J2x1OuO2T2R2E2L2I2A2B2C2D2E2F2G2H2I2J', 'CLIENTE', 'INACTIVO', 'Argentina', NULL, NULL),

-- ID 3 | Password: pass123
(3, 'Carlos Gómez', 'cgomez@example.com', '$2y$10$8mK2O0L5P9s1A2B3C4D5Eu.A1B2C3D4E5F6G7H8I9J0K1L2M3N4O5', 'CLIENTE', 'ACTIVO', 'Chile', NULL, NULL),

-- ID 4 | Password: nombre123
(4, 'nombre', 'nombre@gmail.com', '$2y$10$G4A5B6C7D8E9F0G1H2I3J4e5F6G7H8I9J0K1L2M3N4O5P6Q7R8S9T', 'CLIENTE', 'ACTIVO', 'Uruguay', NULL, NULL),

-- ID 5 | Password: matias123
(5, 'matias', 'matias@gmail.com', '$2y$10$H5B6C7D8E9F0G1H2I3J4K5f6G7H8I9J0K1L2M3N4O5P6Q7R8S9T0U', 'CLIENTE', 'ACTIVO', 'Uruguay', NULL, NULL),

-- ID 6 | Password: admin123
(6, 'admin', 'admin@gmail.com', '$2y$10$I6C7D8E9F0G1H2I3J4K5L6g7H8I9J0K1L2M3N4O5P6Q7R8S9T0U1V', 'ADMIN', 'ACTIVO', 'Uruguay', 'ptlc_aUGNsV1gQyu9o0O2sQQzjY4vCvc0KHrujPNIqfFAu5I', NULL),

-- ID 11 | Password: usuario123
(11, 'usuario', 'pterodactyl_user@example.com', '$2y$10$J7D8E9F0G1H2I3J4K5L6M7h8I9J0K1L2M3N4O5P6Q7R8S9T0U1V2W', 'CLIENTE', 'ACTIVO', 'Uruguay', NULL, NULL);

-- ---------------------------------------------------------
-- 2. TABLA: JUEGO
-- ---------------------------------------------------------

INSERT INTO JUEGO (id_juego, nest_id, nombre, descripcion, imagen, estado) VALUES
(1, 1, 'Minecraft', 'Servidores de la categoría Minecraft (Paper, Forge, Fabric, Vanilla, etc.)', 'minecraft.jpeg', 'ACTIVO'),
(2, 2, 'Source Engine', 'Juegos basados en el motor Source de Valve (CS:GO, GMod, TF2, ARK, etc.)', 'cs2.jpeg', 'ACTIVO'),
(3, 3, 'Voice Servers', 'Servidores de comunicación por voz (Teamspeak 3, Mumble)', NULL, 'ACTIVO'),
(4, 4, 'Rust', 'Servidores para el juego de supervivencia Rust', NULL, 'ACTIVO'),
(5, 5, 'Terraria', 'Servidores del juego Terraria (Vanilla, TShock)', 'terraria.jpeg', 'ACTIVO');

-- ---------------------------------------------------------
-- 3. TABLA: VARIACION_JUEGO (Eggs de Pterodactyl)
-- ---------------------------------------------------------
INSERT INTO VARIACION_JUEGO (id_variacion, id_juego, nombre_variacion, descripcion_variacion, egg_id) VALUES
-- Minecraft (id_juego: 1)
(1, 1, 'Paper', 'High performance Spigot fork that aims to fix gameplay and mechanics inconsistencies.', 1),
(2, 1, 'Forge Minecraft', 'Minecraft Forge Server. Modding API to create and manage mods.', 2),
(3, 1, 'Bungeecord', 'Proxy software to connect multiple Minecraft servers together.', 3),
(4, 1, 'Sponge (SpongeVanilla)', 'SpongeVanilla is the SpongeAPI implementation for Vanilla Minecraft.', 4),
(5, 1, 'Vanilla Minecraft', 'Minecraft is a game about placing blocks and going on adventures.', 5),
(17, 1, 'Fabric', 'Fabric is a modular modding toolchain targeting Minecraft 1.14 and above.', 17),
(18, 1, 'Minecraft Extra', 'Juego adicional para satisfacer las referencias FK del servidor.', 18),
(25, 1, 'Fabric Extra', 'Juego adicional para satisfacer las referencias FK del servidor.', 25),
-- Source Engine (id_juego: 2)
(6, 2, 'Ark: Survival Evolved', 'Stranded, naked, freezing, and starving on the island called ARK.', 6),
(7, 2, 'Counter-Strike: Global Offensive', 'Multiplayer first-person shooter video game.', 7),
(8, 2, 'Garrys Mod', 'Sandbox physics game created by Garry Newman.', 8),
(9, 2, 'Insurgency', 'Take to the streets for intense close quarters combat.', 9),
(10, 2, 'Team Fortress 2', 'Team-based first-person shooter multiplayer video game.', 10),
(11, 2, 'Custom Source Engine Game', 'Option allows modifying the startup arguments.', 11),
-- Voice Servers (id_juego: 3)
(12, 3, 'Teamspeak3 Server', 'VoIP software designed with security in mind.', 12),
(13, 3, 'Mumble Server', 'Open source, low-latency, high quality voice chat software.', 13),
-- Rust (id_juego: 4)
(14, 4, 'Rust', 'The only aim in Rust is to survive.', 14),
-- Terraria (id_juego: 5)
(15, 5, 'Terraria Vanilla', 'Dig, fight, explore, build!', 15),
(16, 5, 'tshock', 'The t-shock modded terraria server.', 16);

-- ---------------------------------------------------------
-- 4. TABLA: PLAN
-- ---------------------------------------------------------
TRUNCATE TABLE PLAN;

INSERT INTO PLAN (id_plan, nombre, descripcion, costo, max_jugadores, duracion, id_contrato, ram_gb, prioridad, soporte_24_7, tag) VALUES
(1, 'Plan Básico Minecraft', 'Ideal para jugar con un grupo pequeño de amigos.', 5.00, 10, 30, 101, 2, 'BAJA', TRUE, 'MEJOR_PRECIO'),
(2, 'Plan Avanzado Minecraft', 'Excelente rendimiento para servidores modded o con plugins.', 12.50, 30, 30, 102, 6, 'MEDIA', TRUE, 'MAS_VENDIDO'),
(3, 'Plan Alto Rendimiento', 'Para comunidades grandes con alto tráfico de usuarios.', 25.00, 100, 30, 103, 16, 'ALTA', TRUE, 'RECOMENDADO');

-- ---------------------------------------------------------
-- 5. TABLA: SERVIDOR
-- ---------------------------------------------------------
TRUNCATE TABLE SERVIDOR;

INSERT INTO SERVIDOR (nombre, descripcion, version_juego, dominio, puerto, estado, id_pterodactyl, id_variacion, id_usuario) VALUES
('minecraft server', 'Servidor principal de pruebas', '1.20.1', 'mc.ejemplo.com', 25565, 'ACTIVO', '1cbf818f', 8, 6),
('server', 'Servidor secundario', '1.19.4', 'srv.ejemplo.com', 25566, 'DETENIDO', '2c2bff35', 18, 6),
('funciona?', 'Servidor de pruebas temporales', '1.18.2', NULL, NULL, 'ACTIVO', '7', 4, 11),
('D:', 'Servidor de supervivencia', '1.20.2', NULL, NULL, 'DETENIDO', '93202751', 4, 11),
('Fabric prueba', 'Servidor modded con Fabric', '1.20.1', 'fabric.ejemplo.com', 25567, 'ACTIVO', '6552571f', 25, 6);

-- ---------------------------------------------------------
-- 6. TABLA: ASIGNA
-- ---------------------------------------------------------
TRUNCATE TABLE ASIGNA;

INSERT INTO ASIGNA (id_usuario, id_plan, fecha_contratacion) VALUES
(1, 1, '2026-01-15'),
(5, 2, '2026-02-10'),
(6, 3, '2026-03-01');

-- ---------------------------------------------------------
-- 7. TABLA: HISTORIAL_PAGO
-- ---------------------------------------------------------
TRUNCATE TABLE HISTORIAL_PAGO;

INSERT INTO HISTORIAL_PAGO (metodo, monto, fecha_pago, estado, id_usuario) VALUES
('Tarjeta de Crédito', 5.00, '2026-01-15', 'CONFIRMADO', 1),
('PayPal', 12.50, '2026-02-10', 'CONFIRMADO', 5),
('Transferencia Bancaria', 25.00, '2026-03-01', 'PENDIENTE', 6);

-- ---------------------------------------------------------
-- 8. TABLA: TICKET
-- ---------------------------------------------------------
TRUNCATE TABLE TICKET;

INSERT INTO TICKET (asunto, descripcion, fecha_soporte, estado, id_usuario) VALUES
('Problema al encender servidor', 'El servidor de Fabric se queda en ciclo de reinicio.', '2026-03-05', 'ABIERTO', 6),
('Consulta de facturación', 'Deseo cambiar el método de pago registrado.', '2026-03-02', 'CERRADO', 1);

-- ---------------------------------------------------------
-- 9. TABLA: LOG
-- ---------------------------------------------------------
TRUNCATE TABLE LOG;

INSERT INTO LOG (tipo, mensaje, fecha, id_servidor) VALUES
('INFO', 'El servidor se inició correctamente.', '2026-03-05 10:00:00', 1),
('WARN', 'Uso elevado de memoria RAM detectado (>90%).', '2026-03-05 10:15:00', 1),
('ERROR', 'Crash report generado por fallo en un mod.', '2026-03-05 11:30:00', 5);

-- ---------------------------------------------------------
-- 10. TABLA: REGLA_AUTOMATICA
-- ---------------------------------------------------------
TRUNCATE TABLE REGLA_AUTOMATICA;

INSERT INTO REGLA_AUTOMATICA (condicion, accion, id_servidor) VALUES
('Uso de RAM > 95% por más de 5 minutos', 'REINICIAR', 1),
('Sin jugadores conectados a las 04:00 AM', 'REINICIAR', 5);

SET FOREIGN_KEY_CHECKS = 1;