@extends('layouts.public')

@section('title', 'Registrarse - BiblioTech')

@section('content')
<div style="min-height: 100vh; display: flex; align-items: center; justify-content: center; background: white; padding: 2rem 0;">
    <div style="width: 100%; max-width: 520px; margin: 2rem; background: white; border-radius: 20px; box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1); overflow: hidden;">
        <div style="background: linear-gradient(135deg, var(--primary) 0%, #1e40af 100%); padding: 2rem; text-align: center; color: white;">
            <div style="font-size: 4rem; margin-bottom: 1rem;">
                <i class="fas fa-user-plus"></i>
            </div>
            <h2 style="margin-bottom: 0.5rem; font-size: 1.8rem; font-weight: 700;">Únete a BiblioTech</h2>
            <p style="opacity: 0.9; font-size: 1rem;">Crea tu cuenta y explora nuestra biblioteca</p>
        </div>
        
        <div style="padding: 2.5rem;">
            <form method="POST" action="{{ route('register') }}">
                @csrf
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">
                    <div>
                        <label for="nombre" style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: var(--dark);">Nombre *</label>
                        <input type="text" 
                               id="nombre" 
                               name="nombre" 
                               style="width: 100%; padding: 0.875rem; border: 2px solid var(--border); border-radius: 10px; font-size: 0.95rem; transition: all 0.3s;" 
                               value="{{ old('nombre') }}" 
                               required>
                        @error('nombre')
                            <div style="color: var(--danger); font-size: 0.8rem; margin-top: 0.25rem;">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="apellido" style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: var(--dark);">Apellido *</label>
                        <input type="text" 
                               id="apellido" 
                               name="apellido" 
                               style="width: 100%; padding: 0.875rem; border: 2px solid var(--border); border-radius: 10px; font-size: 0.95rem; transition: all 0.3s;" 
                               value="{{ old('apellido') }}" 
                               required>
                        @error('apellido')
                            <div style="color: var(--danger); font-size: 0.8rem; margin-top: 0.25rem;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div style="margin-bottom: 1.5rem;">
                    <label for="email" style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: var(--dark);">Correo Electrónico *</label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           style="width: 100%; padding: 0.875rem; border: 2px solid var(--border); border-radius: 10px; font-size: 0.95rem; transition: all 0.3s;" 
                           value="{{ old('email') }}" 
                           required>
                    @error('email')
                        <div style="color: var(--danger); font-size: 0.8rem; margin-top: 0.25rem;">{{ $message }}</div>
                    @enderror
                </div>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">
                    <div>
                        <label for="codigo_estudiante" style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: var(--dark);">Código Estudiante</label>
                        <input type="text" 
                               id="codigo_estudiante" 
                               name="codigo_estudiante" 
                               style="width: 100%; padding: 0.875rem; border: 2px solid var(--border); border-radius: 10px; font-size: 0.95rem; transition: all 0.3s;" 
                               value="{{ old('codigo_estudiante') }}" 
                               placeholder="Opcional">
                        @error('codigo_estudiante')
                            <div style="color: var(--danger); font-size: 0.8rem; margin-top: 0.25rem;">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="tipo_usuario" style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: var(--dark);">Tipo de Usuario *</label>
                        <select id="tipo_usuario" 
                                name="tipo_usuario" 
                                style="width: 100%; padding: 0.875rem; border: 2px solid var(--border); border-radius: 10px; font-size: 0.95rem; transition: all 0.3s;" 
                                required>
                            <option value="">Seleccionar</option>
                            <option value="estudiante" {{ old('tipo_usuario') == 'estudiante' ? 'selected' : '' }}>Estudiante</option>
                            <option value="profesor" {{ old('tipo_usuario') == 'profesor' ? 'selected' : '' }}>Profesor</option>
                        </select>
                        @error('tipo_usuario')
                            <div style="color: var(--danger); font-size: 0.8rem; margin-top: 0.25rem;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div style="margin-bottom: 1.5rem;">
                    <label for="telefono" style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: var(--dark);">Teléfono</label>
                    <input type="tel" 
                           id="telefono" 
                           name="telefono" 
                           style="width: 100%; padding: 0.875rem; border: 2px solid var(--border); border-radius: 10px; font-size: 0.95rem; transition: all 0.3s;" 
                           value="{{ old('telefono') }}" 
                           placeholder="Opcional">
                    @error('telefono')
                        <div style="color: var(--danger); font-size: 0.8rem; margin-top: 0.25rem;">{{ $message }}</div>
                    @enderror
                </div>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 2rem;">
                    <div>
                        <label for="password" style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: var(--dark);">Contraseña *</label>
                        <input type="password" 
                               id="password" 
                               name="password" 
                               style="width: 100%; padding: 0.875rem; border: 2px solid var(--border); border-radius: 10px; font-size: 0.95rem; transition: all 0.3s;" 
                               required>
                        @error('password')
                            <div style="color: var(--danger); font-size: 0.8rem; margin-top: 0.25rem;">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="password_confirmation" style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: var(--dark);">Confirmar Contraseña *</label>
                        <input type="password" 
                               id="password_confirmation" 
                               name="password_confirmation" 
                               style="width: 100%; padding: 0.875rem; border: 2px solid var(--border); border-radius: 10px; font-size: 0.95rem; transition: all 0.3s;" 
                               required>
                    </div>
                </div>

                <button type="submit" style="width: 100%; background: linear-gradient(135deg, var(--primary) 0%, #1e40af 100%); color: white; padding: 1rem; border: none; border-radius: 12px; font-size: 1rem; font-weight: 600; cursor: pointer; transition: all 0.3s; margin-bottom: 1.5rem;">
                    <i class="fas fa-user-plus" style="margin-right: 0.5rem;"></i>
                    Crear Cuenta
                </button>
            </form>

            <div style="text-align: center; padding-top: 1.5rem; border-top: 1px solid var(--border);">
                <p style="color: var(--secondary); margin-bottom: 1rem; font-size: 0.9rem;">¿Ya tienes una cuenta?</p>
                <a href="{{ route('login') }}" style="display: inline-flex; align-items: center; gap: 0.5rem; color: var(--primary); text-decoration: none; font-weight: 600; transition: all 0.3s;">
                    <i class="fas fa-sign-in-alt"></i>
                    Iniciar Sesión
                </a>
            </div>
        </div>
    </div>
</div>

<style>
input:focus, select:focus {
    outline: none;
    border-color: var(--primary) !important;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1) !important;
}

button:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(59, 130, 246, 0.3);
}
</style>
@endsection