-- BiblioTech Database Schema
CREATE DATABASE bibliotech;
USE bibliotech;

-- Tabla de categorías
CREATE TABLE categorias (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabla de autores
CREATE TABLE autores (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(150) NOT NULL,
    apellido VARCHAR(150) NOT NULL,
    biografia TEXT,
    fecha_nacimiento DATE,
    nacionalidad VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabla de libros
CREATE TABLE libros (
    id INT PRIMARY KEY AUTO_INCREMENT,
    titulo VARCHAR(255) NOT NULL,
    isbn VARCHAR(20) UNIQUE,
    autor_id INT,
    categoria_id INT,
    editorial VARCHAR(150),
    año_publicacion YEAR,
    numero_paginas INT,
    cantidad_total INT DEFAULT 1,
    cantidad_disponible INT DEFAULT 1,
    ubicacion VARCHAR(100),
    descripcion TEXT,
    imagen_portada VARCHAR(255),
    estado ENUM('activo', 'inactivo', 'mantenimiento') DEFAULT 'activo',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (autor_id) REFERENCES autores(id) ON DELETE SET NULL,
    FOREIGN KEY (categoria_id) REFERENCES categorias(id) ON DELETE SET NULL,
    INDEX idx_titulo (titulo),
    INDEX idx_isbn (isbn),
    INDEX idx_autor (autor_id),
    INDEX idx_categoria (categoria_id)
);

-- Tabla de usuarios
CREATE TABLE usuarios (
    id INT PRIMARY KEY AUTO_INCREMENT,
    codigo_estudiante VARCHAR(20) UNIQUE,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    telefono VARCHAR(20),
    direccion TEXT,
    tipo_usuario ENUM('estudiante', 'profesor', 'bibliotecario', 'admin') DEFAULT 'estudiante',
    estado ENUM('activo', 'suspendido', 'inactivo') DEFAULT 'activo',
    fecha_registro DATE DEFAULT (CURRENT_DATE),
    multa_pendiente DECIMAL(10,2) DEFAULT 0.00,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_codigo (codigo_estudiante),
    INDEX idx_email (email),
    INDEX idx_tipo (tipo_usuario)
);

-- Tabla de préstamos
CREATE TABLE prestamos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    usuario_id INT NOT NULL,
    libro_id INT NOT NULL,
    fecha_prestamo DATE NOT NULL,
    fecha_devolucion_esperada DATE NOT NULL,
    fecha_devolucion_real DATE NULL,
    estado ENUM('activo', 'devuelto', 'vencido', 'renovado') DEFAULT 'activo',
    multa DECIMAL(10,2) DEFAULT 0.00,
    observaciones TEXT,
    bibliotecario_prestamo_id INT,
    bibliotecario_devolucion_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (libro_id) REFERENCES libros(id) ON DELETE CASCADE,
    FOREIGN KEY (bibliotecario_prestamo_id) REFERENCES usuarios(id) ON DELETE SET NULL,
    FOREIGN KEY (bibliotecario_devolucion_id) REFERENCES usuarios(id) ON DELETE SET NULL,
    INDEX idx_usuario (usuario_id),
    INDEX idx_libro (libro_id),
    INDEX idx_fecha_prestamo (fecha_prestamo),
    INDEX idx_fecha_devolucion (fecha_devolucion_esperada),
    INDEX idx_estado (estado)
);

-- Tabla de reservas
CREATE TABLE reservas (
    id INT PRIMARY KEY AUTO_INCREMENT,
    usuario_id INT NOT NULL,
    libro_id INT NOT NULL,
    fecha_reserva DATE NOT NULL,
    fecha_expiracion DATE NOT NULL,
    estado ENUM('activa', 'cumplida', 'cancelada', 'expirada') DEFAULT 'activa',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (libro_id) REFERENCES libros(id) ON DELETE CASCADE,
    INDEX idx_usuario_reserva (usuario_id),
    INDEX idx_libro_reserva (libro_id),
    INDEX idx_estado_reserva (estado)
);

-- Insertar datos de ejemplo
INSERT INTO categorias (nombre, descripcion) VALUES
('Ficción', 'Novelas y cuentos de ficción'),
('Ciencia', 'Libros de ciencias exactas y naturales'),
('Historia', 'Libros de historia y biografías'),
('Tecnología', 'Libros de informática y tecnología'),
('Literatura', 'Clásicos de la literatura universal');

INSERT INTO autores (nombre, apellido, nacionalidad) VALUES
('Gabriel', 'García Márquez', 'Colombiana'),
('Isaac', 'Asimov', 'Estadounidense'),
('Yuval Noah', 'Harari', 'Israelí'),
('Miguel de', 'Cervantes', 'Española'),
('Stephen', 'King', 'Estadounidense');
