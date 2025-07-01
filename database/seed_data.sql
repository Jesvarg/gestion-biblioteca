-- BiblioTech - Datos de prueba para la aplicación
-- Ejecutar después de las migraciones

USE bibliotech;

-- Limpiar datos existentes (opcional)
SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE TABLE prestamos;
TRUNCATE TABLE libros;
TRUNCATE TABLE autores;
TRUNCATE TABLE categorias;
TRUNCATE TABLE usuarios;
SET FOREIGN_KEY_CHECKS = 1;

-- Insertar categorías
INSERT INTO categorias (nombre, descripcion, created_at, updated_at) VALUES
('Ficción', 'Novelas y cuentos de ficción', NOW(), NOW()),
('Ciencia', 'Libros de ciencias naturales y exactas', NOW(), NOW()),
('Historia', 'Libros de historia mundial y local', NOW(), NOW()),
('Tecnología', 'Libros sobre programación, informática y tecnología', NOW(), NOW()),
('Literatura Clásica', 'Obras clásicas de la literatura universal', NOW(), NOW()),
('Biografías', 'Biografías de personajes históricos', NOW(), NOW()),
('Filosofía', 'Obras filosóficas y de pensamiento', NOW(), NOW()),
('Arte', 'Libros sobre arte, pintura y cultura', NOW(), NOW());

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

-- Insertar libros
INSERT INTO libros (titulo, isbn, categoria_id, autor_id, editorial, fecha_publicacion, numero_paginas, descripcion, ubicacion, estado, imagen, created_at, updated_at) VALUES
('Cien años de soledad', '978-84-376-0494-7', 1, 1, 'Editorial Sudamericana', '1967-06-05', 471, 'Obra maestra del realismo mágico que narra la historia de la familia Buendía', 'A-001', 'disponible', 'cien_anos_soledad.jpg', NOW(), NOW()),
('Fundación', '978-0-553-29335-0', 2, 2, 'Gnome Press', '1951-05-01', 244, 'Primera novela de la serie Fundación, obra cumbre de la ciencia ficción', 'B-002', 'disponible', 'fundacion.jpg', NOW(), NOW()),
('Don Quijote de la Mancha', '978-84-376-0675-0', 5, 3, 'Francisco de Robles', '1605-01-16', 863, 'La obra más importante de la literatura española', 'C-003', 'disponible', 'don_quijote.jpg', NOW(), NOW()),
('Orgullo y prejuicio', '978-0-14-143951-8', 1, 4, 'T. Egerton', '1813-01-28', 432, 'Novela romántica que critica la sociedad de la época', 'A-004', 'disponible', 'orgullo_prejuicio.jpg', NOW(), NOW()),
('Breve historia del tiempo', '978-0-553-38016-3', 2, 5, 'Bantam Books', '1988-04-01', 256, 'Divulgación científica sobre cosmología y física teórica', 'B-005', 'disponible', 'breve_historia_tiempo.jpg', NOW(), NOW()),
('Sapiens: De animales a dioses', '978-84-9992-275-0', 3, 6, 'Debate', '2011-01-01', 496, 'Breve historia de la humanidad desde la prehistoria hasta la actualidad', 'C-006', 'disponible', 'sapiens.jpg', NOW(), NOW()),
('Código limpio', '978-0-13-235088-4', 4, 7, 'Prentice Hall', '2008-08-01', 464, 'Manual de estilo para el desarrollo ágil de software', 'D-007', 'disponible', 'codigo_limpio.jpg', NOW(), NOW()),
('La señora Dalloway', '978-0-15-628275-1', 5, 8, 'Hogarth Press', '1925-05-14', 194, 'Novela modernista que transcurre en un solo día en Londres', 'A-008', 'disponible', 'senora_dalloway.jpg', NOW(), NOW()),
('El amor en los tiempos del cólera', '978-84-376-0495-4', 1, 1, 'Editorial Sudamericana', '1985-12-05', 348, 'Historia de amor que transcurre a lo largo de más de cincuenta años', 'A-009', 'prestado', 'amor_tiempos_colera.jpg', NOW(), NOW()),
('Yo, Robot', '978-0-553-29438-8', 2, 2, 'Gnome Press', '1950-12-02', 253, 'Colección de relatos sobre robots y las tres leyes de la robótica', 'B-010', 'disponible', 'yo_robot.jpg', NOW(), NOW()),
('Emma', '978-0-14-143955-6', 1, 4, 'John Murray', '1815-12-23', 474, 'Novela sobre una joven que se cree casamentera', 'A-011', 'disponible', 'emma.jpg', NOW(), NOW()),
('Homo Deus', '978-84-9992-673-4', 3, 6, 'Debate', '2015-01-01', 496, 'Breve historia del mañana', 'C-012', 'disponible', 'homo_deus.jpg', NOW(), NOW()),
('Arquitectura limpia', '978-0-13-449416-6', 4, 7, 'Prentice Hall', '2017-09-20', 432, 'Guía para estructurar y organizar software', 'D-013', 'disponible', 'arquitectura_limpia.jpg', NOW(), NOW()),
('Al faro', '978-0-15-602997-2', 5, 8, 'Hogarth Press', '1927-05-05', 209, 'Novela experimental sobre el paso del tiempo', 'A-014', 'disponible', 'al_faro.jpg', NOW(), NOW()),
('El universo elegante', '978-84-8432-781-4', 2, 5, 'Crítica', '1999-02-01', 448, 'Supercuerdas, dimensiones ocultas y la búsqueda de la teoría final', 'B-015', 'disponible', 'universo_elegante.jpg', NOW(), NOW());

-- Insertar usuarios (password: "password" para todos)
INSERT INTO usuarios (nombre, apellido, email, telefono, direccion, tipo_usuario, fecha_registro, estado, password, created_at, updated_at) VALUES
('Admin', 'Sistema', 'admin@bibliotech.com', '555-0001', 'Oficina Principal', 'admin', NOW(), 'activo', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NOW(), NOW()),
('María', 'González', 'maria.gonzalez@email.com', '555-0002', 'Calle Principal 123', 'usuario', NOW(), 'activo', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NOW(), NOW()),
('Juan', 'Pérez', 'juan.perez@email.com', '555-0003', 'Avenida Central 456', 'usuario', NOW(), 'activo', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NOW(), NOW()),
('Ana', 'Martínez', 'ana.martinez@email.com', '555-0004', 'Plaza Mayor 789', 'usuario', NOW(), 'activo', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NOW(), NOW()),
('Carlos', 'López', 'carlos.lopez@email.com', '555-0005', 'Barrio Norte 321', 'usuario', NOW(), 'activo', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NOW(), NOW()),
('Bibliotecario', 'Principal', 'bibliotecario@bibliotech.com', '555-0006', 'Biblioteca Central', 'bibliotecario', NOW(), 'activo', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NOW(), NOW());

-- Insertar préstamos
INSERT INTO prestamos (libro_id, usuario_id, fecha_prestamo, fecha_devolucion_esperada, fecha_devolucion_real, estado, observaciones, created_at, updated_at) VALUES
(9, 2, '2024-01-15', '2024-01-29', NULL, 'activo', 'Préstamo regular', NOW(), NOW()),
(3, 3, '2024-01-10', '2024-01-24', '2024-01-22', 'devuelto', 'Devuelto en buen estado', NOW(), NOW()),
(5, 4, '2024-01-12', '2024-01-26', '2024-01-25', 'devuelto', 'Devuelto a tiempo', NOW(), NOW()),
(7, 5, '2024-01-08', '2024-01-22', '2024-01-28', 'devuelto', 'Devuelto con retraso de 6 días', NOW(), NOW());

-- Mostrar resumen de datos insertados
SELECT 'Categorías insertadas:' as Resumen, COUNT(*) as Total FROM categorias
UNION ALL
SELECT 'Autores insertados:', COUNT(*) FROM autores
UNION ALL
SELECT 'Libros insertados:', COUNT(*) FROM libros
UNION ALL
SELECT 'Usuarios insertados:', COUNT(*) FROM usuarios
UNION ALL
SELECT 'Préstamos insertados:', COUNT(*) FROM prestamos;

-- Verificar estado de libros
SELECT 
    'Libros por estado:' as Info,
    estado,
    COUNT(*) as cantidad
FROM libros 
GROUP BY estado;

-- Verificar usuarios por tipo
SELECT 
    'Usuarios por tipo:' as Info,
    tipo_usuario,
    COUNT(*) as cantidad
FROM usuarios 
GROUP BY tipo_usuario;