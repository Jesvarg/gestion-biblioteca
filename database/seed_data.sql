-- BiblioTech - Datos de prueba corregidos
USE bibliotech;

-- Limpiar datos existentes
SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE TABLE prestamos;
TRUNCATE TABLE libros;
TRUNCATE TABLE autores;
TRUNCATE TABLE categorias;
TRUNCATE TABLE usuarios;
SET FOREIGN_KEY_CHECKS = 1;

-- Insertar categorías (sin duplicados)
INSERT INTO categorias (nombre, descripcion, created_at, updated_at) VALUES
('Ficción', 'Novelas y cuentos de ficción', NOW(), NOW()),
('Ciencia', 'Libros de ciencias naturales y exactas', NOW(), NOW()),
('Historia', 'Libros de historia mundial y local', NOW(), NOW()),
('Tecnología', 'Libros sobre programación, informática y tecnología', NOW(), NOW()),
('Literatura Clásica', 'Obras clásicas de la literatura universal', NOW(), NOW()),
('Biografías', 'Biografías de personajes históricos', NOW(), NOW()),
('Filosofía', 'Obras filosóficas y de pensamiento', NOW(), NOW()),
('Arte', 'Libros sobre arte, pintura y cultura', NOW(), NOW())
ON DUPLICATE KEY UPDATE nombre = VALUES(nombre);

-- Insertar autores
INSERT INTO autores (nombre, apellido, nacionalidad, fecha_nacimiento, biografia, created_at, updated_at) VALUES
('Gabriel', 'García Márquez', 'Colombiana', '1927-03-06', 'Escritor colombiano, premio Nobel de Literatura 1982', NOW(), NOW()),
('Isaac', 'Asimov', 'Estadounidense', '1920-01-02', 'Escritor y profesor de bioquímica, famoso por sus obras de ciencia ficción', NOW(), NOW()),
('Miguel', 'de Cervantes', 'Española', '1547-09-29', 'Escritor español, autor de Don Quijote de la Mancha', NOW(), NOW()),
('Jane', 'Austen', 'Británica', '1775-12-16', 'Novelista británica, conocida por sus novelas románticas', NOW(), NOW()),
('Stephen', 'Hawking', 'Británica', '1942-01-08', 'Físico teórico y cosmólogo británico', NOW(), NOW()),
('Yuval Noah', 'Harari', 'Israelí', '1976-02-24', 'Historiador y escritor israelí', NOW(), NOW()),
('Robert C.', 'Martin', 'Estadounidense', '1952-12-05', 'Ingeniero de software y autor', NOW(), NOW()),
('Virginia', 'Woolf', 'Británica', '1882-01-25', 'Escritora británica, figura del modernismo literario', NOW(), NOW());

-- Insertar libros (campos corregidos según migración)
INSERT INTO libros (titulo, isbn, categoria_id, autor_id, editorial, año_publicacion, numero_paginas, descripcion, ubicacion, estado, imagen_portada, cantidad_total, cantidad_disponible, created_at, updated_at) VALUES
('Cien años de soledad', '978-84-376-0494-7', 1, 1, 'Editorial Sudamericana', 1967, 471, 'Obra maestra del realismo mágico que narra la historia de la familia Buendía', 'A-001', 'activo', 'cien_anos_soledad.jpg', 3, 3, NOW(), NOW()),
('Fundación', '978-0-553-29335-0', 2, 2, 'Gnome Press', 1951, 244, 'Primera novela de la serie Fundación, obra cumbre de la ciencia ficción', 'B-002', 'activo', 'fundacion.jpg', 2, 2, NOW(), NOW()),
('Don Quijote de la Mancha', '978-84-376-0675-0', 5, 3, 'Francisco de Robles', 1605, 863, 'La obra más importante de la literatura española', 'C-003', 'activo', 'don_quijote.jpg', 4, 4, NOW(), NOW()),
('Orgullo y prejuicio', '978-0-14-143951-8', 1, 4, 'T. Egerton', 1813, 432, 'Novela romántica que critica la sociedad de la época', 'A-004', 'activo', 'orgullo_prejuicio.jpg', 2, 2, NOW(), NOW()),
('Breve historia del tiempo', '978-0-553-38016-3', 2, 5, 'Bantam Books', 1988, 256, 'Divulgación científica sobre cosmología y física teórica', 'B-005', 'activo', 'breve_historia_tiempo.jpg', 3, 3, NOW(), NOW()),
('Sapiens: De animales a dioses', '978-84-9992-275-0', 3, 6, 'Debate', 2011, 496, 'Breve historia de la humanidad desde la prehistoria hasta la actualidad', 'C-006', 'activo', 'sapiens.jpg', 2, 2, NOW(), NOW()),
('Código limpio', '978-0-13-235088-4', 4, 7, 'Prentice Hall', 2008, 464, 'Manual de estilo para el desarrollo ágil de software', 'D-007', 'activo', 'codigo_limpio.jpg', 1, 1, NOW(), NOW()),
('La señora Dalloway', '978-0-15-628275-1', 5, 8, 'Hogarth Press', 1925, 194, 'Novela modernista que transcurre en un solo día en Londres', 'A-008', 'activo', 'senora_dalloway.jpg', 2, 2, NOW(), NOW()),
('El amor en los tiempos del cólera', '978-84-376-0495-4', 1, 1, 'Editorial Sudamericana', 1985, 348, 'Historia de amor que transcurre a lo largo de más de cincuenta años', 'A-009', 'activo', 'amor_tiempos_colera.jpg', 2, 1, NOW(), NOW()),
('Yo, Robot', '978-0-553-29438-8', 2, 2, 'Gnome Press', 1950, 253, 'Colección de relatos sobre robots y las tres leyes de la robótica', 'B-010', 'activo', 'yo_robot.jpg', 3, 3, NOW(), NOW());

-- Insertar usuarios (password hasheado para 'bibliotech2024')
INSERT INTO usuarios (nombre, apellido, email, telefono, direccion, tipo_usuario, fecha_registro, estado, codigo_estudiante, multa_pendiente, created_at, updated_at) VALUES
('Admin', 'Sistema', 'admin@bibliotech.com', '555-0001', 'Oficina Principal', 'admin', CURDATE(), 'activo', NULL, 0.00, NOW(), NOW()),
('María', 'González', 'maria.gonzalez@email.com', '555-0002', 'Calle Principal 123', 'estudiante', CURDATE(), 'activo', 'EST001', 0.00, NOW(), NOW()),
('Juan', 'Pérez', 'juan.perez@email.com', '555-0003', 'Avenida Central 456', 'estudiante', CURDATE(), 'activo', 'EST002', 0.00, NOW(), NOW()),
('Ana', 'Martínez', 'ana.martinez@email.com', '555-0004', 'Plaza Mayor 789', 'profesor', CURDATE(), 'activo', NULL, 0.00, NOW(), NOW()),
('Carlos', 'López', 'carlos.lopez@email.com', '555-0005', 'Barrio Norte 321', 'estudiante', CURDATE(), 'activo', 'EST003', 0.00, NOW(), NOW()),
('Bibliotecario', 'Principal', 'bibliotecario@bibliotech.com', '555-0006', 'Biblioteca Central', 'bibliotecario', CURDATE(), 'activo', NULL, 0.00, NOW(), NOW());

-- Insertar préstamos
INSERT INTO prestamos (libro_id, usuario_id, fecha_prestamo, fecha_devolucion_esperada, fecha_devolucion_real, estado, observaciones, bibliotecario_prestamo_id, created_at, updated_at) VALUES
(9, 2, '2024-01-15', '2024-01-29', NULL, 'activo', 'Préstamo regular', 6, NOW(), NOW()),
(3, 3, '2024-01-10', '2024-01-24', '2024-01-22', 'devuelto', 'Devuelto en buen estado', 6, NOW(), NOW()),
(5, 4, '2024-01-12', '2024-01-26', '2024-01-25', 'devuelto', 'Devuelto a tiempo', 6, NOW(), NOW()),
(7, 5, '2024-01-08', '2024-01-22', '2024-01-28', 'devuelto', 'Devuelto con retraso de 6 días', 6, NOW(), NOW());

-- Mostrar resumen
SELECT 'Datos insertados correctamente' as Status;