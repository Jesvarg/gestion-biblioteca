<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'BiblioTech')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        :root {
            --primary: #3b82f6;
            --secondary: #6b7280;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --dark: #1f2937;
            --light: #f8fafc;
            --border: #e5e7eb;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: var(--dark);
            background: #ffffff;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }
        
        /* Header */
        .header {
            background: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        .header-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem 0;
        }
        
        .logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary);
            text-decoration: none;
        }
        
        .logo:hover {
            color: var(--primary);
            text-decoration: none;
        }
        
        .nav {
            display: flex;
            align-items: center;
            gap: 2rem;
        }
        
        .nav-link {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            color: var(--secondary);
            text-decoration: none;
            border-radius: 6px;
            transition: all 0.2s;
            font-weight: 500;
        }
        
        .nav-link:hover {
            color: var(--primary);
            background: rgba(59, 130, 246, 0.1);
            text-decoration: none;
        }
        
        .nav-link.active {
            color: var(--primary);
            background: rgba(59, 130, 246, 0.1);
        }
        
        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 6px;
            font-weight: 500;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s;
            font-size: 0.875rem;
        }
        
        .btn-primary {
            background: var(--primary);
            color: white;
        }
        
        .btn-primary:hover {
            background: #2563eb;
            color: white;
            text-decoration: none;
        }
        
        .btn-outline {
            background: transparent;
            color: var(--primary);
            border: 2px solid var(--primary);
        }
        
        .btn-outline:hover {
            background: var(--primary);
            color: white;
            text-decoration: none;
        }
        
        .btn-lg {
            padding: 1rem 2rem;
            font-size: 1rem;
        }
        
        .btn-sm {
            padding: 0.5rem 1rem;
            font-size: 0.75rem;
        }
        
        /* Main Content */
        .main {
            min-height: calc(100vh - 200px);
        }
        
        /* Footer */
        .footer {
            background: var(--dark);
            color: white;
            padding: 3rem 0 1rem;
            margin-top: 4rem;
        }
        
        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }
        
        .footer-section h3 {
            margin-bottom: 1rem;
            color: var(--primary);
        }
        
        .footer-section p,
        .footer-section a {
            color: #d1d5db;
            text-decoration: none;
            margin-bottom: 0.5rem;
            display: block;
        }
        
        .footer-section a:hover {
            color: var(--primary);
        }
        
        .footer-bottom {
            border-top: 1px solid #374151;
            padding-top: 1rem;
            text-align: center;
            color: #9ca3af;
        }
        
        /* Alerts */
        .alert {
            padding: 1rem;
            border-radius: 6px;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .alert-success {
            background: rgba(34, 197, 94, 0.1);
            color: rgb(34, 197, 94);
            border: 1px solid rgba(34, 197, 94, 0.2);
        }
        
        .alert-error {
            background: rgba(239, 68, 68, 0.1);
            color: rgb(239, 68, 68);
            border: 1px solid rgba(239, 68, 68, 0.2);
        }
        
        /* Mobile Menu */
        .mobile-menu-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--secondary);
            cursor: pointer;
        }
        
        /* Tailwind compatibility */
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        @media (max-width: 768px) {
            .nav {
                display: none;
            }
            
            .mobile-menu-toggle {
                display: block;
            }
            
            .header-content {
                flex-wrap: wrap;
            }
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="container">
            <div class="header-content">
                <a href="{{ route('home') }}" class="logo">
                    <i class="fas fa-book"></i>
                    BiblioTech
                </a>
                
                <nav class="nav">
                    <a href="{{ route('catalogo.index') }}" class="nav-link {{ request()->routeIs('catalogo.*') ? 'active' : '' }}">
                        <i class="fas fa-book"></i>
                        Libros
                    </a>
                    
                    @auth
                        @if(in_array(auth()->user()->tipo_usuario, ['bibliotecario', 'admin']))
                            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                                <i class="fas fa-tachometer-alt"></i>
                                Administración
                            </a>
                        @endif
                        
                        <a href="{{ route('perfil') }}" class="nav-link {{ request()->routeIs('perfil') ? 'active' : '' }}">
                            <i class="fas fa-user"></i>
                            Mi Perfil
                        </a>
                        
                        <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                            @csrf
                            <button type="submit" class="nav-link" style="background: none; border: none; cursor: pointer;">
                                <i class="fas fa-sign-out-alt"></i>
                                Cerrar Sesión
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="nav-link {{ request()->routeIs('login') ? 'active' : '' }}">
                            <i class="fas fa-sign-in-alt"></i>
                            Iniciar Sesión
                        </a>
                        
                        <a href="{{ route('register') }}" class="btn btn-primary">
                            <i class="fas fa-user-plus"></i>
                            Registrarse
                        </a>
                    @endauth
                </nav>
                
                <button class="mobile-menu-toggle">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>
    </header>
    
    <!-- Main Content -->
    <main class="main">
        <!-- Alerts -->
        @if(session('success'))
            <div class="container">
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    {{ session('success') }}
                </div>
            </div>
        @endif
        
        @if(session('error'))
            <div class="container">
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ session('error') }}
                </div>
            </div>
        @endif
        
        @yield('content')
    </main>
    
    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>BiblioTech</h3>
                    <p>Sistema moderno de gestión bibliotecaria que conecta a los usuarios con el conocimiento de manera eficiente y accesible.</p>
                    <p><i class="fas fa-envelope"></i> info@bibliotech.com</p>
                    <p><i class="fas fa-phone"></i> +1 (555) 123-4567</p>
                </div>
                
                <div class="footer-section">
                    <h3>Enlaces Rápidos</h3>
                    <a href="{{ route('catalogo.index') }}">Catálogo de Libros</a>
                    <a href="{{ route('catalogo.index', ['categoria' => 1]) }}">Ficción</a>
                    <a href="{{ route('catalogo.index', ['categoria' => 2]) }}">Ciencia</a>
                    <a href="{{ route('catalogo.index', ['categoria' => 3]) }}">Historia</a>
                </div>
                
                <div class="footer-section">
                    <h3>Servicios</h3>
                    <a href="#">Préstamo de Libros</a>
                    <a href="#">Reservas Online</a>
                    <a href="#">Consulta de Disponibilidad</a>
                    <a href="#">Renovación de Préstamos</a>
                </div>
                
                <div class="footer-section">
                    <h3>Horarios</h3>
                    <p><strong>Lunes - Viernes:</strong> 8:00 AM - 8:00 PM</p>
                    <p><strong>Sábados:</strong> 9:00 AM - 6:00 PM</p>
                    <p><strong>Domingos:</strong> 10:00 AM - 4:00 PM</p>
                    <p><strong>Días Festivos:</strong> Cerrado</p>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} BiblioTech. Todos los derechos reservados. | Desarrollado con ❤️ para la educación.</p>
            </div>
        </div>
    </footer>
    
    @stack('scripts')
</body>
</html>