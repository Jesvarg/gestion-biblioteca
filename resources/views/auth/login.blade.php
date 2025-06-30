@extends('layouts.app')

@section('title', 'Iniciar Sesión')

@section('content')
<div class="min-h-screen flex items-center justify-center" style="background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);">
    <div class="card" style="width: 100%; max-width: 400px; margin: 2rem;">
        <div class="card-body">
            <div class="text-center mb-4">
                <div style="font-size: 3rem; color: var(--primary); margin-bottom: 1rem;">
                    <i class="fas fa-book"></i>
                </div>
                <h2 style="margin-bottom: 0.5rem;">BiblioTech</h2>
                <p style="color: var(--secondary);">Sistema de Gestión Bibliotecaria</p>
            </div>

            <form method="POST" action="{{ route('login') }}">
                @csrf
                
                <div class="form-group">
                    <label for="email">Correo Electrónico</label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           class="form-control @error('email') is-invalid @enderror" 
                           value="{{ old('email') }}" 
                           required 
                           autofocus>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" 
                           id="password" 
                           name="password" 
                           class="form-control @error('password') is-invalid @enderror" 
                           required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="flex items-center">
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        <span class="ml-2">Recordarme</span>
                    </label>
                </div>

                <button type="submit" class="btn btn-primary w-full">
                    <i class="fas fa-sign-in-alt"></i>
                    Iniciar Sesión
                </button>
            </form>

            <div class="text-center mt-4">
                <p style="color: var(--secondary); font-size: 0.875rem;">
                    Credenciales por defecto: cualquier email + contraseña: <strong>bibliotech2024</strong>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
