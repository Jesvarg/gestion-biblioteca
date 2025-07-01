@extends('layouts.public')

@section('title', 'Registrarse - BiblioTech')

@section('content')
<div class="min-h-screen flex items-center justify-center" style="background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%); padding: 2rem 0;">
    <div class="card" style="width: 100%; max-width: 500px; margin: 2rem; background: white; border-radius: 12px; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);">
        <div class="card-body" style="padding: 2rem;">
            <div class="text-center mb-4">
                <div style="font-size: 3rem; color: var(--primary); margin-bottom: 1rem;">
                    <i class="fas fa-user-plus"></i>
                </div>
                <h2 style="margin-bottom: 0.5rem; color: var(--dark);">Crear Cuenta</h2>
                <p style="color: var(--secondary);">Únete a la comunidad BiblioTech</p>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                    <div class="form-group">
                        <label for="nombre" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Nombre *</label>
                        <input type="text" 
                               id="nombre" 
                               name="nombre" 
                               style="width: 100%; padding: 0.75rem; border: 2px solid var(--border); border-radius: 6px; font-size: 1rem;" 
                               value="{{ old('nombre') }}" 
                               required>
                        @error('nombre')
                            <div style="color: var(--danger); font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="apellido" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Apellido *</label>
                        <input type="text" 
                               id="apellido" 
                               name="apellido" 
                               style="width: 100%; padding: 0.75rem; border: 2px solid var(--border); border-radius: 6px; font-size: 1rem;" 
                               value="{{ old('apellido') }}" 
                               required>
                        @error('apellido')
                            <div style="color: var(--danger); font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="form-group" style="margin-bottom: 1rem;">
                    <label for="email" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Correo Electrónico *</label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           style="width: 100%; padding: 0.75rem; border: 2px solid var(--border); border-radius: 6px; font-size: 1rem;" 
                           value="{{ old('email') }}" 
                           required>
                    @error('email')
                        <div style="color: var(--danger); font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                    @enderror
                </div>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                    <div class="form-group">
                        <label for="codigo_estudiante" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Código Estudiante</label>
                        <input type="text" 
                               id="codigo_estudiante" 
                               name="codigo_estudiante" 
                               style="width: 100%; padding: 0.75rem; border: 2px solid var(--border); border-radius: 6px; font-size: 1rem;" 
                               value="{{ old('codigo_estudiante') }}" 
                               placeholder="Opcional">
                        @error('codigo_estudiante')
                            <div style="color: var(--danger); font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="tipo_usuario" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Tipo de Usuario *</label>
                        <select id="tipo_usuario" 
                                name="tipo_usuario" 
                                style="width: 100%; padding: 0.75rem; border: 2px solid var(--border); border-radius: 6px; font-size: 1rem;" 
                                required>
                            <option value="">Seleccionar</option>
                            <option value="estudiante" {{ old('tipo_usuario') == 'estudiante' ? 'selected' : '' }}>Estudiante</option>
                            <option value="profesor" {{ old('tipo_usuario') == 'profesor' ? 'selected' : '' }}>Profesor</option>
                        </select>
                        @error('tipo_usuario')
                            <div style="color: var(--danger); font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="form-group" style="margin-bottom: 1rem;">
                    <label for="telefono" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Teléfono</label>
                    <input type="tel" 
                           id="telefono" 
                           name="telefono" 
                           style="width: 100%; padding: 0.75rem; border: 2px solid var(--border); border-radius: 6px; font-size: 1rem;" 
                           value="{{ old('telefono') }}" 
                           placeholder="Opcional">
                    @error('telefono')
                        <div style="color: var(--danger); font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                    @enderror
                </div>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                    <div class="form-group">
                        <label for="password" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Contraseña *</label>
                        <input type="password" 
                               id="password" 
                               name="password" 
                               style="width: 100%; padding: 0.75rem; border: 2px solid var(--border); border-radius: 6px; font-size: 1rem;" 
                               required>
                        @error('password')
                            <div style="color: var(--danger); font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="password_confirmation" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Confirmar Contraseña *</label>
                        <input type="password" 
                               id="password_confirmation" 
                               name="password_confirmation" 
                               style="width: 100%; padding: 0.75rem; border: 2px solid var(--border); border-radius: 6px; font-size: 1rem;" 
                               required>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; margin-bottom: 1rem;">
                    <i class="fas fa-user-plus"></i>
                    Crear Cuenta
                </button>
            </form>

            <div class="text-center">
                <p style="color: var(--secondary); margin-bottom: 1rem;">¿Ya tienes una cuenta?</p>
                <a href="{{ route('login') }}" class="btn btn-outline" style="width: 100%;">
                    <i class="fas fa-sign-in-alt"></i>
                    Iniciar Sesión
                </a>
            </div>
        </div>
    </div>
</div>
@endsection