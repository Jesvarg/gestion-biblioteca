<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuario;
use App\Models\Categoria;
use App\Models\Autor;
use App\Models\Libro;
use App\Models\Prestamo;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Crear categorías
        $categorias = [
            ['nombre' => 'Ficción', 'descripcion' => 'Novelas y cuentos de ficción'],
            ['nombre' => 'Ciencia', 'descripcion' => 'Libros de ciencias naturales y exactas'],
            ['nombre' => 'Historia', 'descripcion' => 'Libros de historia mundial y local'],
            ['nombre' => 'Tecnología', 'descripcion' => 'Libros sobre programación, informática y tecnología'],
            ['nombre' => 'Literatura Clásica', 'descripcion' => 'Obras clásicas de la literatura universal'],
            ['nombre' => 'Biografías', 'descripcion' => 'Biografías de personajes históricos'],
            ['nombre' => 'Filosofía', 'descripcion' => 'Obras filosóficas y de pensamiento'],
            ['nombre' => 'Arte', 'descripcion' => 'Libros sobre arte, pintura y cultura']
        ];

        foreach ($categorias as $categoria) {
            Categoria::create($categoria);
        }

        // Crear autores
        $autores = [
            ['nombre' => 'Gabriel', 'apellido' => 'García Márquez', 'nacionalidad' => 'Colombiana', 'fecha_nacimiento' => '1927-03-06', 'biografia' => 'Escritor colombiano, premio Nobel de Literatura 1982'],
            ['nombre' => 'Isaac', 'apellido' => 'Asimov', 'nacionalidad' => 'Estadounidense', 'fecha_nacimiento' => '1920-01-02', 'biografia' => 'Escritor y profesor de bioquímica, famoso por sus obras de ciencia ficción'],
            ['nombre' => 'Miguel', 'apellido' => 'de Cervantes', 'nacionalidad' => 'Española', 'fecha_nacimiento' => '1547-09-29', 'biografia' => 'Escritor español, autor de Don Quijote de la Mancha'],
            ['nombre' => 'Jane', 'apellido' => 'Austen', 'nacionalidad' => 'Británica', 'fecha_nacimiento' => '1775-12-16', 'biografia' => 'Novelista británica, conocida por sus novelas románticas'],
            ['nombre' => 'Stephen', 'apellido' => 'Hawking', 'nacionalidad' => 'Británica', 'fecha_nacimiento' => '1942-01-08', 'biografia' => 'Físico teórico y cosmólogo británico'],
            ['nombre' => 'Yuval Noah', 'apellido' => 'Harari', 'nacionalidad' => 'Israelí', 'fecha_nacimiento' => '1976-02-24', 'biografia' => 'Historiador y escritor israelí'],
            ['nombre' => 'Robert C.', 'apellido' => 'Martin', 'nacionalidad' => 'Estadounidense', 'fecha_nacimiento' => '1952-12-05', 'biografia' => 'Ingeniero de software y autor'],
            ['nombre' => 'Virginia', 'apellido' => 'Woolf', 'nacionalidad' => 'Británica', 'fecha_nacimiento' => '1882-01-25', 'biografia' => 'Escritora británica, figura del modernismo literario']
        ];

        foreach ($autores as $autor) {
            Autor::create($autor);
        }

        // Crear usuarios con contraseñas hasheadas
        $usuarios = [
            [
                'nombre' => 'Admin',
                'apellido' => 'Sistema',
                'email' => 'admin@bibliotech.com',
                'password' => Hash::make('bibliotech2024'),
                'telefono' => '555-0001',
                'direccion' => 'Oficina Principal',
                'tipo_usuario' => 'admin', // Cambiado de 'administrador' a 'admin'
                'fecha_registro' => now()->toDateString(),
                'estado' => 'activo',
                'codigo_estudiante' => null,
                'multa_pendiente' => 0.00
            ],
            [
                'nombre' => 'María',
                'apellido' => 'González',
                'email' => 'maria.gonzalez@email.com',
                'password' => Hash::make('estudiante123'),
                'telefono' => '555-0002',
                'direccion' => 'Calle Principal 123',
                'tipo_usuario' => 'estudiante',
                'fecha_registro' => now()->toDateString(),
                'estado' => 'activo',
                'codigo_estudiante' => 'EST001',
                'multa_pendiente' => 15.50
            ],
            [
                'nombre' => 'Juan',
                'apellido' => 'Pérez',
                'email' => 'juan.perez@email.com',
                'password' => Hash::make('estudiante123'),
                'telefono' => '555-0003',
                'direccion' => 'Avenida Central 456',
                'tipo_usuario' => 'estudiante',
                'fecha_registro' => now()->toDateString(),
                'estado' => 'activo',
                'codigo_estudiante' => 'EST002',
                'multa_pendiente' => 0.00
            ],
            [
                'nombre' => 'Ana',
                'apellido' => 'Martínez',
                'email' => 'ana.martinez@email.com',
                'password' => Hash::make('profesor123'),
                'telefono' => '555-0004',
                'direccion' => 'Plaza Mayor 789',
                'tipo_usuario' => 'profesor',
                'fecha_registro' => now()->toDateString(),
                'estado' => 'activo',
                'codigo_estudiante' => null,
                'multa_pendiente' => 0.00
            ],
            [
                'nombre' => 'Bibliotecario',
                'apellido' => 'Principal',
                'email' => 'bibliotecario@bibliotech.com',
                'password' => Hash::make('bibliotech2024'),
                'telefono' => '555-0006',
                'direccion' => 'Biblioteca Central',
                'tipo_usuario' => 'bibliotecario',
                'fecha_registro' => now()->toDateString(),
                'estado' => 'activo',
                'codigo_estudiante' => null,
                'multa_pendiente' => 0.00
            ]
        ];

        foreach ($usuarios as $usuario) {
            Usuario::create($usuario);
        }

        // Crear libros
        $libros = [
            [
                'titulo' => 'Cien años de soledad',
                'isbn' => '978-84-376-0494-7',
                'categoria_id' => 1,
                'autor_id' => 1,
                'editorial' => 'Editorial Sudamericana',
                'año_publicacion' => 1967,
                'numero_paginas' => 471,
                'descripcion' => 'Obra maestra del realismo mágico que narra la historia de la familia Buendía',
                'ubicacion' => 'A-001',
                'estado' => 'activo',
                'imagen_portada' => 'cien_anos_soledad.jpg',
                'cantidad_total' => 3,
                'cantidad_disponible' => 2
            ],
            [
                'titulo' => 'Fundación',
                'isbn' => '978-0-553-29335-0',
                'categoria_id' => 2,
                'autor_id' => 2,
                'editorial' => 'Gnome Press',
                'año_publicacion' => 1951,
                'numero_paginas' => 244,
                'descripcion' => 'Primera novela de la serie Fundación, obra cumbre de la ciencia ficción',
                'ubicacion' => 'B-002',
                'estado' => 'activo',
                'imagen_portada' => 'fundacion.jpg',
                'cantidad_total' => 2,
                'cantidad_disponible' => 1
            ],
            [
                'titulo' => 'Don Quijote de la Mancha',
                'isbn' => '978-84-376-0675-0',
                'categoria_id' => 5,
                'autor_id' => 3,
                'editorial' => 'Francisco de Robles',
                'año_publicacion' => 1605,
                'numero_paginas' => 863,
                'descripcion' => 'La obra más importante de la literatura española',
                'ubicacion' => 'C-003',
                'estado' => 'activo',
                'imagen_portada' => 'don_quijote.jpg',
                'cantidad_total' => 4,
                'cantidad_disponible' => 4
            ],
            [
                'titulo' => 'Código limpio',
                'isbn' => '978-0-13-235088-4',
                'categoria_id' => 4,
                'autor_id' => 7,
                'editorial' => 'Prentice Hall',
                'año_publicacion' => 2008,
                'numero_paginas' => 464,
                'descripcion' => 'Manual de estilo para el desarrollo ágil de software',
                'ubicacion' => 'D-007',
                'estado' => 'activo',
                'imagen_portada' => 'codigo_limpio.jpg',
                'cantidad_total' => 1,
                'cantidad_disponible' => 0
            ],
            [
                'titulo' => 'Breve historia del tiempo',
                'isbn' => '978-0-553-38016-3',
                'categoria_id' => 2,
                'autor_id' => 5,
                'editorial' => 'Bantam Books',
                'año_publicacion' => 1988,
                'numero_paginas' => 256,
                'descripcion' => 'Una introducción a la cosmología para el público general',
                'ubicacion' => 'B-005',
                'estado' => 'activo',
                'imagen_portada' => 'breve_historia_tiempo.jpg',
                'cantidad_total' => 2,
                'cantidad_disponible' => 2
            ],
            [
                'titulo' => 'Sapiens',
                'isbn' => '978-0-06-231609-7',
                'categoria_id' => 3,
                'autor_id' => 6,
                'editorial' => 'Harper',
                'año_publicacion' => 2014,
                'numero_paginas' => 443,
                'descripcion' => 'De animales a dioses: Breve historia de la humanidad',
                'ubicacion' => 'C-006',
                'estado' => 'activo',
                'imagen_portada' => 'sapiens.jpg',
                'cantidad_total' => 3,
                'cantidad_disponible' => 3
            ]
        ];

        foreach ($libros as $libro) {
            Libro::create($libro);
        }

        // Crear préstamos de prueba
        $prestamos = [
            // Préstamo activo reciente
            [
                'usuario_id' => 2, // María González
                'libro_id' => 1, // Cien años de soledad
                'fecha_prestamo' => Carbon::now()->subDays(5),
                'fecha_devolucion_esperada' => Carbon::now()->addDays(10),
                'fecha_devolucion_real' => null,
                'estado' => 'activo',
                'multa' => 0.00,
                'observaciones' => 'Préstamo para proyecto de literatura',
                'bibliotecario_prestamo_id' => 5, // Bibliotecario
                'bibliotecario_devolucion_id' => null,
                'created_at' => Carbon::now()->subDays(5),
                'updated_at' => Carbon::now()->subDays(5)
            ],
            // Préstamo vencido
            [
                'usuario_id' => 2, // María González
                'libro_id' => 2, // Fundación
                'fecha_prestamo' => Carbon::now()->subDays(20),
                'fecha_devolucion_esperada' => Carbon::now()->subDays(5),
                'fecha_devolucion_real' => null,
                'estado' => 'activo',
                'multa' => 0.00,
                'observaciones' => 'Préstamo para investigación',
                'bibliotecario_prestamo_id' => 5,
                'bibliotecario_devolucion_id' => null,
                'created_at' => Carbon::now()->subDays(20),
                'updated_at' => Carbon::now()->subDays(20)
            ],
            // Préstamo devuelto con multa
            [
                'usuario_id' => 3, // Juan Pérez
                'libro_id' => 4, // Código limpio
                'fecha_prestamo' => Carbon::now()->subDays(25),
                'fecha_devolucion_esperada' => Carbon::now()->subDays(10),
                'fecha_devolucion_real' => Carbon::now()->subDays(3),
                'estado' => 'devuelto',
                'multa' => 15.50,
                'observaciones' => 'Préstamo para curso de programación. Devuelto con retraso.',
                'bibliotecario_prestamo_id' => 5,
                'bibliotecario_devolucion_id' => 1, // Admin
                'created_at' => Carbon::now()->subDays(25),
                'updated_at' => Carbon::now()->subDays(3)
            ],
            // Préstamo renovado
            [
                'usuario_id' => 4, // Ana Martínez
                'libro_id' => 3, // Don Quijote
                'fecha_prestamo' => Carbon::now()->subDays(12),
                'fecha_devolucion_esperada' => Carbon::now()->addDays(2),
                'fecha_devolucion_real' => null,
                'estado' => 'renovado',
                'multa' => 0.00,
                'observaciones' => 'Préstamo para clase de literatura clásica. Renovado por 7 días adicionales.',
                'bibliotecario_prestamo_id' => 5,
                'bibliotecario_devolucion_id' => null,
                'created_at' => Carbon::now()->subDays(12),
                'updated_at' => Carbon::now()->subDays(5)
            ],
            // Préstamo devuelto a tiempo
            [
                'usuario_id' => 3, // Juan Pérez
                'libro_id' => 1, // Cien años de soledad
                'fecha_prestamo' => Carbon::now()->subDays(30),
                'fecha_devolucion_esperada' => Carbon::now()->subDays(15),
                'fecha_devolucion_real' => Carbon::now()->subDays(16),
                'estado' => 'devuelto',
                'multa' => 0.00,
                'observaciones' => 'Préstamo para lectura personal. Devuelto a tiempo.',
                'bibliotecario_prestamo_id' => 5,
                'bibliotecario_devolucion_id' => 5,
                'created_at' => Carbon::now()->subDays(30),
                'updated_at' => Carbon::now()->subDays(16)
            ],
            // Préstamo activo del profesor
            [
                'usuario_id' => 4, // Ana Martínez
                'libro_id' => 5, // Breve historia del tiempo
                'fecha_prestamo' => Carbon::now()->subDays(3),
                'fecha_devolucion_esperada' => Carbon::now()->addDays(27), // Profesores tienen más tiempo
                'fecha_devolucion_real' => null,
                'estado' => 'activo',
                'multa' => 0.00,
                'observaciones' => 'Préstamo para preparación de clases de física',
                'bibliotecario_prestamo_id' => 1, // Admin
                'bibliotecario_devolucion_id' => null,
                'created_at' => Carbon::now()->subDays(3),
                'updated_at' => Carbon::now()->subDays(3)
            ],
            // Préstamo histórico (para estadísticas)
            [
                'usuario_id' => 2, // María González
                'libro_id' => 6, // Sapiens
                'fecha_prestamo' => Carbon::now()->subMonths(2),
                'fecha_devolucion_esperada' => Carbon::now()->subMonths(2)->addDays(15),
                'fecha_devolucion_real' => Carbon::now()->subMonths(2)->addDays(14),
                'estado' => 'devuelto',
                'multa' => 0.00,
                'observaciones' => 'Préstamo para ensayo de historia',
                'bibliotecario_prestamo_id' => 5,
                'bibliotecario_devolucion_id' => 5,
                'created_at' => Carbon::now()->subMonths(2),
                'updated_at' => Carbon::now()->subMonths(2)->addDays(14)
            ]
        ];

        foreach ($prestamos as $prestamo) {
            Prestamo::create($prestamo);
        }
    }
}
