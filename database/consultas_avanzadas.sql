-- BiblioTech - Consultas SQL Avanzadas

-- 1. Consulta de disponibilidad de libros
-- Muestra libros disponibles con información completa
SELECT 
    l.id,
    l.titulo,
    l.isbn,
    CONCAT(a.nombre, ' ', a.apellido) AS autor_completo,
    c.nombre AS categoria,
    l.cantidad_total,
    l.cantidad_disponible,
    l.ubicacion,
    CASE 
        WHEN l.cantidad_disponible > 0 AND l.estado = 'activo' THEN 'Disponible'
        WHEN l.cantidad_disponible = 0 THEN 'Agotado'
        ELSE 'No disponible'
    END AS estado_disponibilidad
FROM libros l
LEFT JOIN autores a ON l.autor_id = a.id
LEFT JOIN categorias c ON l.categoria_id = c.id
WHERE l.estado = 'activo'
ORDER BY l.titulo;

-- 2. Búsqueda avanzada por múltiples criterios
-- Busca libros por título, autor o categoría
SELECT DISTINCT
    l.id,
    l.titulo,
    l.isbn,
    CONCAT(a.nombre, ' ', a.apellido) AS autor,
    c.nombre AS categoria,
    l.año_publicacion,
    l.cantidad_disponible
FROM libros l
LEFT JOIN autores a ON l.autor_id = a.id
LEFT JOIN categorias c ON l.categoria_id = c.id
WHERE (
    l.titulo LIKE '%término_búsqueda%' OR
    a.nombre LIKE '%término_búsqueda%' OR
    a.apellido LIKE '%término_búsqueda%' OR
    c.nombre LIKE '%término_búsqueda%' OR
    l.isbn LIKE '%término_búsqueda%'
)
AND l.estado = 'activo'
ORDER BY 
    CASE 
        WHEN l.titulo LIKE '%término_búsqueda%' THEN 1
        WHEN CONCAT(a.nombre, ' ', a.apellido) LIKE '%término_búsqueda%' THEN 2
        ELSE 3
    END,
    l.titulo;

-- 3. Reporte de préstamos vencidos
-- Identifica préstamos no devueltos a tiempo
SELECT 
    p.id AS prestamo_id,
    CONCAT(u.nombre, ' ', u.apellido) AS usuario,
    u.codigo_estudiante,
    u.email,
    l.titulo AS libro,
    p.fecha_prestamo,
    p.fecha_devolucion_esperada,
    DATEDIFF(CURDATE(), p.fecha_devolucion_esperada) AS dias_vencido,
    CASE 
        WHEN DATEDIFF(CURDATE(), p.fecha_devolucion_esperada) <= 7 THEN 'Recién vencido'
        WHEN DATEDIFF(CURDATE(), p.fecha_devolucion_esperada) <= 30 THEN 'Vencido'
        ELSE 'Muy vencido'
    END AS nivel_vencimiento,
    (DATEDIFF(CURDATE(), p.fecha_devolucion_esperada) * 0.50) AS multa_calculada
FROM prestamos p
INNER JOIN usuarios u ON p.usuario_id = u.id
INNER JOIN libros l ON p.libro_id = l.id
WHERE p.estado = 'activo' 
    AND p.fecha_devolucion_esperada < CURDATE()
ORDER BY dias_vencido DESC, p.fecha_devolucion_esperada;

-- 4. Vista SQL para estadísticas de libros más prestados
CREATE VIEW vista_libros_populares AS
SELECT 
    l.id,
    l.titulo,
    l.isbn,
    CONCAT(a.nombre, ' ', a.apellido) AS autor,
    c.nombre AS categoria,
    COUNT(p.id) AS total_prestamos,
    COUNT(CASE WHEN p.created_at >= DATE_SUB(CURDATE(), INTERVAL 30 DAY) THEN 1 END) AS prestamos_ultimo_mes,
    COUNT(CASE WHEN p.created_at >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) THEN 1 END) AS prestamos_ultima_semana,
    AVG(DATEDIFF(COALESCE(p.fecha_devolucion_real, CURDATE()), p.fecha_prestamo)) AS promedio_dias_prestamo
FROM libros l
LEFT JOIN autores a ON l.autor_id = a.id
LEFT JOIN categorias c ON l.categoria_id = c.id
LEFT JOIN prestamos p ON l.id = p.libro_id
GROUP BY l.id, l.titulo, l.isbn, autor, categoria
HAVING total_prestamos > 0
ORDER BY total_prestamos DESC;

-- Consulta para usar la vista
SELECT * FROM vista_libros_populares
WHERE prestamos_ultimo_mes > 0
LIMIT 10;

-- 5. Procedimiento almacenado para actualizar estado de préstamos
DELIMITER //

CREATE PROCEDURE ActualizarEstadoPrestamos()
BEGIN
    DECLARE done INT DEFAULT FALSE;
    DECLARE prestamo_id INT;
    DECLARE dias_vencido INT;
    DECLARE multa_calculada DECIMAL(10,2);
    
    -- Cursor para préstamos vencidos
    DECLARE cur CURSOR FOR 
        SELECT id, DATEDIFF(CURDATE(), fecha_devolucion_esperada)
        FROM prestamos 
        WHERE estado = 'activo' 
        AND fecha_devolucion_esperada < CURDATE();
    
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;
    
    -- Iniciar transacción
    START TRANSACTION;
    
    OPEN cur;
    
    read_loop: LOOP
        FETCH cur INTO prestamo_id, dias_vencido;
        IF done THEN
            LEAVE read_loop;
        END IF;
        
        -- Calcular multa (0.50 por día vencido)
        SET multa_calculada = dias_vencido * 0.50;
        
        -- Actualizar estado del préstamo
        UPDATE prestamos 
        SET estado = 'vencido',
            multa = multa_calculada
        WHERE id = prestamo_id;
        
        -- Actualizar multa del usuario
        UPDATE usuarios u
        INNER JOIN prestamos p ON u.id = p.usuario_id
        SET u.multa_pendiente = u.multa_pendiente + multa_calculada
        WHERE p.id = prestamo_id;
        
    END LOOP;
    
    CLOSE cur;
    
    -- Confirmar transacción
    COMMIT;
    
    -- Mostrar resumen
    SELECT 
        COUNT(*) AS prestamos_actualizados,
        SUM(multa) AS total_multas_aplicadas
    FROM prestamos 
    WHERE estado = 'vencido' 
    AND DATE(updated_at) = CURDATE();
    
END //

DELIMITER ;

-- Ejecutar el procedimiento
-- CALL ActualizarEstadoPrestamos();

-- 6. Índices para optimización de consultas
-- Índices para mejorar rendimiento de búsquedas frecuentes

-- Índice compuesto para búsquedas de libros
CREATE INDEX idx_libros_busqueda ON libros(titulo, estado, cantidad_disponible);

-- Índice para préstamos por fecha
CREATE INDEX idx_prestamos_fecha_estado ON prestamos(fecha_devolucion_esperada, estado);

-- Índice para usuarios activos
CREATE INDEX idx_usuarios_activos ON usuarios(estado, tipo_usuario);

-- Índice para búsquedas de autores
CREATE INDEX idx_autores_nombre_completo ON autores(apellido, nombre);

-- Índice para estadísticas de préstamos
CREATE INDEX idx_prestamos_estadisticas ON prestamos(created_at, libro_id, usuario_id);

-- 7. Consulta de análisis de rendimiento
-- Usar EXPLAIN para analizar consultas lentas
EXPLAIN SELECT 
    l.titulo,
    COUNT(p.id) as total_prestamos
FROM libros l
LEFT JOIN prestamos p ON l.id = p.libro_id
WHERE l.estado = 'activo'
GROUP BY l.id, l.titulo
ORDER BY total_prestamos DESC
LIMIT 10;

-- 8. Consultas de reportes adicionales

-- Usuarios más activos por período
SELECT 
    CONCAT(u.nombre, ' ', u.apellido) AS usuario,
    u.codigo_estudiante,
    u.tipo_usuario,
    COUNT(p.id) AS total_prestamos,
    COUNT(CASE WHEN p.estado = 'activo' THEN 1 END) AS prestamos_activos,
    COUNT(CASE WHEN p.estado = 'vencido' THEN 1 END) AS prestamos_vencidos,
    SUM(p.multa) AS total_multas
FROM usuarios u
LEFT JOIN prestamos p ON u.id = p.usuario_id
WHERE u.tipo_usuario != 'bibliotecario'
    AND p.created_at >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
GROUP BY u.id, usuario, u.codigo_estudiante, u.tipo_usuario
HAVING total_prestamos > 0
ORDER BY total_prestamos DESC
LIMIT 15;

-- Estadísticas por categoría
SELECT 
    c.nombre AS categoria,
    COUNT(DISTINCT l.id) AS total_libros,
    COUNT(p.id) AS total_prestamos,
    ROUND(COUNT(p.id) / COUNT(DISTINCT l.id), 2) AS promedio_prestamos_por_libro,
    COUNT(CASE WHEN p.estado = 'activo' THEN 1 END) AS prestamos_activos
FROM categorias c
LEFT JOIN libros l ON c.id = l.categoria_id
LEFT JOIN prestamos p ON l.id = p.libro_id
GROUP BY c.id, c.nombre
ORDER BY total_prestamos DESC;

-- Tendencia de préstamos por mes
SELECT 
    YEAR(created_at) AS año,
    MONTH(created_at) AS mes,
    MONTHNAME(created_at) AS nombre_mes,
    COUNT(*) AS total_prestamos,
    COUNT(DISTINCT usuario_id) AS usuarios_unicos,
    COUNT(DISTINCT libro_id) AS libros_unicos
FROM prestamos
WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 12 MONTH)
GROUP BY año, mes, nombre_mes
ORDER BY año DESC, mes DESC;
