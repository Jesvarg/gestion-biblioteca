@extends('layouts.public')

@section('title', 'BiblioTech - Sistema de Gestión Bibliotecaria')

@section('content')
<!-- Hero Section -->
<section class="hero">
    <div class="container">
        <div class="hero-content">
            <div class="hero-text">
                <h1 class="hero-title">Bienvenido a BiblioTech</h1>
                <p class="hero-subtitle">Tu biblioteca digital. Explora y descubre nuevos títulos</p>
                <div class="hero-actions">
                    <a href="{{ route('catalogo.index') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-search"></i>
                        Explorar Catálogo
                    </a>
                </div>
            </div>
            <div class="hero-image">
                <div class="hero-graphic">
                    <i class="fas fa-book-open"></i>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Libros Destacados -->
<section class="featured-books">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Libros Más Populares</h2>
            <p class="section-subtitle">Los títulos más solicitados por nuestra comunidad</p>
        </div>
        
        <div class="books-grid">
            @forelse($librosDestacados as $libro)
                <div class="book-card">
                    <div class="book-cover">
                        @if($libro->imagen_portada)
                            <img src="{{ Storage::url($libro->imagen_portada) }}" alt="{{ $libro->titulo }}">
                        @else
                            <div class="book-placeholder">
                                <i class="fas fa-book"></i>
                            </div>
                        @endif
                        <div class="book-overlay">
                            <a href="{{ route('catalogo.libro', $libro) }}" class="btn btn-sm btn-primary">
                                Ver Detalles
                            </a>
                        </div>
                    </div>
                    <div class="book-info">
                        <h3 class="book-title">{{ Str::limit($libro->titulo, 40) }}</h3>
                        <p class="book-author">{{ $libro->autor->nombre_completo ?? 'Autor desconocido' }}</p>
                        <p class="book-category">{{ $libro->categoria->nombre ?? 'Sin categoría' }}</p>
                        <div class="book-status">
                            @if($libro->cantidad_disponible > 0)
                                <span class="status available">
                                    <i class="fas fa-check-circle"></i>
                                    Disponible
                                </span>
                            @else
                                <span class="status unavailable">
                                    <i class="fas fa-times-circle"></i>
                                    No disponible
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-8">
                    <p class="text-gray-500">No hay libros destacados disponibles.</p>
                </div>
            @endforelse
        </div>
        
        <div class="text-center mt-8">
            <a href="{{ route('catalogo.index') }}" class="btn btn-outline">
                Ver Todos los Libros
                <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
    </div>
</section>

<!-- Categorías -->
<section class="categories">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Explora por Categorías</h2>
            <p class="section-subtitle">Encuentra libros organizados por temas de tu interés</p>
        </div>
        
        <div class="categories-grid">
            @foreach($categorias as $categoria)
                <a href="{{ route('catalogo.index', ['categoria' => $categoria->id]) }}" class="category-card">
                    <div class="category-icon">
                        <i class="fas fa-{{ $categoria->icono ?? 'book' }}"></i>
                    </div>
                    <h3 class="category-name">{{ $categoria->nombre }}</h3>
                    <p class="category-count">{{ $categoria->libros_count }} libros</p>
                </a>
            @endforeach
        </div>
    </div>
</section>

<!-- Call to Action -->
@guest
<section class="cta">
    <div class="container">
        <div class="cta-content">
            <h2 class="cta-title">¿Listo para comenzar?</h2>
            <p class="cta-subtitle">Únete a nuestra comunidad y accede a miles de libros</p>
            <div class="cta-actions">
                <a href="{{ route('register') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-user-plus"></i>
                    Crear Cuenta
                </a>
                <a href="{{ route('login') }}" class="btn btn-outline btn-lg">
                    <i class="fas fa-sign-in-alt"></i>
                    Iniciar Sesión
                </a>
            </div>
        </div>
    </div>
</section>
@endguest
@endsection

@push('styles')
<style>
/* Hero Section */
.hero {
    background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
    color: white;
    padding: 4rem 0;
    margin-bottom: 4rem;
}

.hero-content {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 3rem;
    align-items: center;
}

.hero-title {
    font-size: 3rem;
    font-weight: 700;
    margin-bottom: 1rem;
    line-height: 1.2;
}

.hero-subtitle {
    font-size: 1.25rem;
    margin-bottom: 2rem;
    opacity: 0.9;
}

.hero-stats {
    display: flex;
    gap: 2rem;
    margin-bottom: 2rem;
}

.stat {
    text-align: center;
}

.stat-number {
    display: block;
    font-size: 2rem;
    font-weight: 700;
}

.stat-label {
    font-size: 0.875rem;
    opacity: 0.8;
}

.hero-actions {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}

.hero-graphic {
    text-align: center;
    font-size: 8rem;
    opacity: 0.3;
}

/* Books Grid */
.books-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 2rem;
    margin-bottom: 2rem;
}

.book-card {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: transform 0.2s, box-shadow 0.2s;
}

.book-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.book-cover {
    position: relative;
    height: 200px;
    background: var(--light);
    overflow: hidden;
}

.book-cover img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.book-placeholder {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100%;
    font-size: 3rem;
    color: var(--secondary);
}

.book-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.7);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.2s;
}

.book-card:hover .book-overlay {
    opacity: 1;
}

.book-info {
    padding: 1.5rem;
}

.book-title {
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: var(--dark);
}

.book-author {
    color: var(--secondary);
    margin-bottom: 0.25rem;
}

.book-category {
    color: var(--primary);
    font-size: 0.875rem;
    margin-bottom: 1rem;
}

.book-status .status {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.875rem;
    font-weight: 500;
}

.status.available {
    background: rgba(34, 197, 94, 0.1);
    color: rgb(34, 197, 94);
}

.status.unavailable {
    background: rgba(239, 68, 68, 0.1);
    color: rgb(239, 68, 68);
}

/* Categories Grid */
.categories-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.5rem;
}

.category-card {
    background: white;
    padding: 2rem;
    border-radius: 12px;
    text-align: center;
    text-decoration: none;
    color: inherit;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    transition: all 0.2s;
}

.category-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    color: inherit;
    text-decoration: none;
}

.category-icon {
    font-size: 2.5rem;
    color: var(--primary);
    margin-bottom: 1rem;
}

.category-name {
    font-size: 1.25rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.category-count {
    color: var(--secondary);
    font-size: 0.875rem;
}

/* CTA Section */
.cta {
    background: var(--light);
    padding: 4rem 0;
    text-align: center;
}

.cta-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 1rem;
}

.cta-subtitle {
    font-size: 1.25rem;
    color: var(--secondary);
    margin-bottom: 2rem;
}

.cta-actions {
    display: flex;
    gap: 1rem;
    justify-content: center;
    flex-wrap: wrap;
}

/* Sections */
.featured-books,
.categories {
    padding: 4rem 0;
}

.section-header {
    text-align: center;
    margin-bottom: 3rem;
}

.section-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 1rem;
}

.section-subtitle {
    font-size: 1.25rem;
    color: var(--secondary);
}

/* Responsive */
@media (max-width: 768px) {
    .hero-content {
        grid-template-columns: 1fr;
        text-align: center;
    }
    
    .hero-title {
        font-size: 2rem;
    }
    
    .books-grid {
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    }
    
    .categories-grid {
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    }
}
</style>
@endpush