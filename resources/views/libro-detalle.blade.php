@extends('layouts.public')

@section('title', $libro->titulo)

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Breadcrumb -->
    <nav class="mb-8">
        <ol style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.875rem; color: var(--secondary);">
            <li><a href="{{ route('home') }}" style="color: var(--primary); text-decoration: none;">Inicio</a></li>
            <li><i class="fas fa-chevron-right" style="font-size: 0.75rem;"></i></li>
            <li><a href="{{ route('catalogo.index') }}" style="color: var(--primary); text-decoration: none;">Catálogo</a></li>
            <li><i class="fas fa-chevron-right" style="font-size: 0.75rem;"></i></li>
            <li style="color: var(--dark);">{{ $libro->titulo }}</li>
        </ol>
    </nav>

    <div style="background: white; border-radius: 12px; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1); overflow: hidden;">
        <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 2rem; padding: 2rem;">
            <!-- Imagen del libro -->
            <div>
                <div style="aspect-ratio: 3/4; background: #f3f4f6; border-radius: 12px; overflow: hidden; display: flex; align-items: center; justify-content: center;">
                    <img src="https://picsum.photos/400/600?random={{ $libro->id }}" 
                         alt="{{ $libro->titulo }}"
                         style="width: 100%; height: 100%; object-fit: cover;">
                </div>
            </div>

            <!-- Información del libro -->
            <div>
                <div style="margin-bottom: 1.5rem;">
                    <h1 style="font-size: 2rem; font-weight: 700; color: var(--dark); margin-bottom: 1rem;">{{ $libro->titulo }}</h1>
                    
                    <!-- Estado -->
                    <div style="margin-bottom: 1rem;">
                        @if($libro->cantidad_disponible > 0)
                            <span style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.5rem 1rem; border-radius: 50px; font-size: 0.875rem; font-weight: 500; background: #dcfce7; color: #166534;">
                                <i class="fas fa-check-circle"></i>
                                Disponible ({{ $libro->cantidad_disponible }} copias)
                            </span>
                        @else
                            <span style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.5rem 1rem; border-radius: 50px; font-size: 0.875rem; font-weight: 500; background: #fee2e2; color: #dc2626;">
                                <i class="fas fa-times-circle"></i>
                                No disponible
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Detalles -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 2rem;">
                    <div>
                        <h3 style="font-size: 1.125rem; font-weight: 600; color: var(--dark); margin-bottom: 1rem;">Información del libro</h3>
                        <dl style="display: grid; gap: 0.75rem;">
                            <div>
                                <dt style="font-size: 0.875rem; font-weight: 500; color: var(--secondary);">Autor</dt>
                                <dd style="font-size: 0.875rem; color: var(--dark);">{{ $libro->autor->nombre }} {{ $libro->autor->apellido }}</dd>
                            </div>
                            <div>
                                <dt style="font-size: 0.875rem; font-weight: 500; color: var(--secondary);">Categoría</dt>
                                <dd style="font-size: 0.875rem; color: var(--dark);">{{ $libro->categoria->nombre }}</dd>
                            </div>
                            <div>
                                <dt style="font-size: 0.875rem; font-weight: 500; color: var(--secondary);">Editorial</dt>
                                <dd style="font-size: 0.875rem; color: var(--dark);">{{ $libro->editorial ?? 'No disponible' }}</dd>
                            </div>
                            <div>
                                <dt style="font-size: 0.875rem; font-weight: 500; color: var(--secondary);">ISBN</dt>
                                <dd style="font-size: 0.875rem; color: var(--dark);">{{ $libro->isbn ?? 'No disponible' }}</dd>
                            </div>
                        </dl>
                    </div>

                    <div>
                        <h3 style="font-size: 1.125rem; font-weight: 600; color: var(--dark); margin-bottom: 1rem;">Detalles adicionales</h3>
                        <dl style="display: grid; gap: 0.75rem;">
                            <div>
                                <dt style="font-size: 0.875rem; font-weight: 500; color: var(--secondary);">Año de publicación</dt>
                                <dd style="font-size: 0.875rem; color: var(--dark);">{{ $libro->año_publicacion ?? 'No disponible' }}</dd>
                            </div>
                            <div>
                                <dt style="font-size: 0.875rem; font-weight: 500; color: var(--secondary);">Número de páginas</dt>
                                <dd style="font-size: 0.875rem; color: var(--dark);">{{ $libro->numero_paginas ?? 'No disponible' }}</dd>
                            </div>
                            <div>
                                <dt style="font-size: 0.875rem; font-weight: 500; color: var(--secondary);">Ubicación</dt>
                                <dd style="font-size: 0.875rem; color: var(--dark);">{{ $libro->ubicacion ?? 'No disponible' }}</dd>
                            </div>
                            <div>
                                <dt style="font-size: 0.875rem; font-weight: 500; color: var(--secondary);">Nacionalidad del autor</dt>
                                <dd style="font-size: 0.875rem; color: var(--dark);">{{ $libro->autor->nacionalidad ?? 'No disponible' }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <!-- Descripción -->
                @if($libro->descripcion)
                    <div style="margin-bottom: 2rem;">
                        <h3 style="font-size: 1.125rem; font-weight: 600; color: var(--dark); margin-bottom: 1rem;">Descripción</h3>
                        <p style="color: var(--secondary); line-height: 1.6;">{{ $libro->descripcion }}</p>
                    </div>
                @endif

                <!-- Biografía del autor -->
                @if($libro->autor->biografia)
                    <div style="margin-bottom: 2rem;">
                        <h3 style="font-size: 1.125rem; font-weight: 600; color: var(--dark); margin-bottom: 1rem;">Sobre el autor</h3>
                        <p style="color: var(--secondary); line-height: 1.6;">{{ $libro->autor->biografia }}</p>
                    </div>
                @endif

                <!-- Acciones -->
                <div style="display: flex; gap: 1rem;">
                    @auth
                        @if($libro->cantidad_disponible > 0)
                            <button style="background: var(--success); color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 8px; font-weight: 500; cursor: pointer; transition: all 0.2s; display: flex; align-items: center; gap: 0.5rem;">
                                <i class="fas fa-book-reader"></i>
                                Solicitar préstamo
                            </button>
                        @else
                            <button disabled style="background: #9ca3af; color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 8px; font-weight: 500; cursor: not-allowed; display: flex; align-items: center; gap: 0.5rem;">
                                <i class="fas fa-times-circle"></i>
                                No disponible
                            </button>
                        @endif
                    @else
                        <a href="{{ route('login') }}" 
                           style="background: var(--primary); color: white; padding: 0.75rem 1.5rem; border-radius: 8px; font-weight: 500; text-decoration: none; transition: all 0.2s; display: flex; align-items: center; gap: 0.5rem;">
                            <i class="fas fa-sign-in-alt"></i>
                            Inicia sesión para solicitar
                        </a>
                    @endauth
                    
                    <a href="{{ route('catalogo.index') }}" 
                       style="background: #6b7280; color: white; padding: 0.75rem 1.5rem; border-radius: 8px; font-weight: 500; text-decoration: none; transition: all 0.2s; display: flex; align-items: center; gap: 0.5rem;">
                        <i class="fas fa-arrow-left"></i>
                        Volver al catálogo
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Libros relacionados -->
    @if(isset($librosRelacionados) && $librosRelacionados->count() > 0)
        <div style="margin-top: 3rem;">
            <h2 style="font-size: 1.5rem; font-weight: 700; color: var(--dark); margin-bottom: 1.5rem;">Libros relacionados</h2>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem;">
                @foreach($librosRelacionados as $relacionado)
                    <div style="background: white; border-radius: 12px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); overflow: hidden; transition: all 0.2s;">
                        <div style="height: 8rem; background: #f3f4f6; display: flex; align-items: center; justify-content: center;">
                            <img src="https://picsum.photos/200/120?random={{ $relacionado->id + 1000 }}" 
                                 alt="{{ $relacionado->titulo }}"
                                 style="height: 100%; width: 100%; object-fit: cover;">
                        </div>
                        <div style="padding: 1rem;">
                            <h3 style="font-weight: 600; color: var(--dark); margin-bottom: 0.5rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">{{ $relacionado->titulo }}</h3>
                            <p style="color: var(--secondary); font-size: 0.875rem; margin-bottom: 0.5rem;">{{ $relacionado->autor->nombre }} {{ $relacionado->autor->apellido }}</p>
                            <a href="{{ route('catalogo.libro', $relacionado) }}" 
                               style="color: var(--primary); font-size: 0.875rem; font-weight: 500; text-decoration: none;">
                                Ver detalles →
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection