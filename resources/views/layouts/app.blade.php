<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ config('app.name', 'BiblioTech') }} - @yield('title', 'Sistema de Gestión')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    
    <!-- Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <!-- Styles -->
    <style>
        :root {
            --primary: #3b82f6;
            --primary-dark: #2563eb;
            --secondary: #64748b;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --light: #f8fafc;
            --dark: #1e293b;
            --border: #e2e8f0;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--light);
            color: var(--dark);
            line-height: 1.6;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }
        
        /* Header */
        .header {
            background: white;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 0;
        }
        
        .logo {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary);
            text-decoration: none;
        }
        
        .nav {
            display: flex;
            gap: 2rem;
            align-items: center;
        }
        
        .nav-link {
            color: var(--secondary);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .nav-link:hover, .nav-link.active {
            color: var(--primary);
        }
        
        /* Main Content */
        .main {
            min-height: calc(100vh - 80px);
            padding: 2rem 0;
        }
        
        .page-header {
            margin-bottom: 2rem;
        }
        
        .page-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 0.5rem;
        }
        
        .page-subtitle {
            color: var(--secondary);
            font-size: 1.1rem;
        }
        
        /* Cards */
        .card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            overflow: hidden;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        
        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        
        .card-header {
            padding: 1.5rem;
            border-bottom: 1px solid var(--border);
            background: var(--light);
        }
        
        .card-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--dark);
        }
        
        .card-body {
            padding: 1.5rem;
        }
        
        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 8px;
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
            background: var(--primary-dark);
            transform: translateY(-1px);
        }
        
        .btn-secondary {
            background: var(--secondary);
            color: white;
        }
        
        .btn-success {
            background: var(--success);
            color: white;
        }
        
        .btn-warning {
            background: var(--warning);
            color: white;
        }
        
        .btn-danger {
            background: var(--danger);
            color: white;
        }
        
        .btn-outline {
            background: transparent;
            border: 2px solid var(--primary);
            color: var(--primary);
        }
        
        .btn-outline:hover {
            background: var(--primary);
            color: white;
        }
        
        /* Forms */
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--dark);
        }
        
        .form-control {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid var(--border);
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.2s;
        }
        
        .form-control:focus {
            outline: none;
            border-color: var(--primary);
        }
        
        .form-error {
            color: var(--danger);
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }
        
        /* Alerts */
        .alert {
            padding: 1rem 1.5rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .alert-success {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
        }
        
        .alert-error {
            background: #fef2f2;
            color: #dc2626;
            border: 1px solid #fecaca;
        }
        
        .alert-warning {
            background: #fffbeb;
            color: #d97706;
            border: 1px solid #fed7aa;
        }
        
        /* Grid */
        .grid {
            display: grid;
            gap: 1.5rem;
        }
        
        .grid-2 {
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        }
        
        .grid-3 {
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        }
        
        .grid-4 {
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        }
        
        /* Utilities */
        .flex {
            display: flex;
        }
        
        .items-center {
            align-items: center;
        }
        
        .justify-between {
            justify-content: space-between;
        }
        
        .gap-4 {
            gap: 1rem;
        }
        
        .text-center {
            text-align: center;
        }
        
        .text-sm {
            font-size: 0.875rem;
        }
        
        .text-lg {
            font-size: 1.125rem;
        }
        
        .font-semibold {
            font-weight: 600;
        }
        
        .mb-4 {
            margin-bottom: 1rem;
        }
        
        .mt-4 {
            margin-top: 1rem;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .nav {
                display: none;
            }
            
            .page-title {
                font-size: 1.5rem;
            }
            
            .card-body {
                padding: 1rem;
            }
        }
        
        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .fade-in {
            animation: fadeIn 0.5s ease-out;
        }
        
        /* Loading */
        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid #f3f3f3;
            border-top: 3px solid var(--primary);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="container">
            <div class="header-content">
                <a href="{{ route('dashboard') }}" class="logo">
                    <i class="fas fa-book"></i>
                    BiblioTech
                </a>
                
                <nav class="nav">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="fas fa-home"></i>
                        Dashboard
                    </a>
                    <a href="{{ route('libros.index') }}" class="nav-link {{ request()->routeIs('libros.*') ? 'active' : '' }}">
                        <i class="fas fa-book"></i>
                        Libros
                    </a>
                    <a href="{{ route('usuarios.index') }}" class="nav-link {{ request()->routeIs('usuarios.*') ? 'active' : '' }}">
                        <i class="fas fa-users"></i>
                        Usuarios
                    </a>
                    <a href="{{ route('prestamos.index') }}" class="nav-link {{ request()->routeIs('prestamos.*') ? 'active' : '' }}">
                        <i class="fas fa-exchange-alt"></i>
                        Préstamos
                    </a>
                    <a href="{{ route('reportes.index') }}" class="nav-link {{ request()->routeIs('reportes.*') ? 'active' : '' }}">
                        <i class="fas fa-chart-bar"></i>
                        Reportes
                    </a>
                </nav>
            </div>
        </div>
    </header>
    
    <!-- Main Content -->
    <main class="main">
        <div class="container">
            <!-- Alerts -->
            @if(session('success'))
                <div class="alert alert-success fade-in">
                    <i class="fas fa-check-circle"></i>
                    {{ session('success') }}
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-error fade-in">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ session('error') }}
                </div>
            @endif
            
            @if(session('warning'))
                <div class="alert alert-warning fade-in">
                    <i class="fas fa-exclamation-triangle"></i>
                    {{ session('warning') }}
                </div>
            @endif
            
            @yield('content')
        </div>
    </main>
    
    <!-- Scripts -->
    <script>
        // Auto-hide alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateY(-20px)';
                    setTimeout(() => alert.remove(), 300);
                }, 5000);
            });
        });
        
        // Form validation
        function validateForm(form) {
            const requiredFields = form.querySelectorAll('[required]');
            let isValid = true;
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    field.style.borderColor = 'var(--danger)';
                    isValid = false;
                } else {
                    field.style.borderColor = 'var(--border)';
                }
            });
            
            return isValid;
        }
        
        // Loading states
        function showLoading(button) {
            const originalText = button.innerHTML;
            button.innerHTML = '<span class="loading"></span> Procesando...';
            button.disabled = true;
            
            return function() {
                button.innerHTML = originalText;
                button.disabled = false;
            };
        }
    </script>
    
    @stack('scripts')
</body>
</html>