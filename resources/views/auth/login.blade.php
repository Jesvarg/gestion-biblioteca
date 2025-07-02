@extends('layouts.public')

@section('title', 'Iniciar Sesión - BiblioTech')

@section('content')
<div style="min-height: 100vh; display: flex; align-items: center; justify-content: center; background: white; padding: 2rem 0;">
    <div style="width: 100%; max-width: 420px; margin: 2rem; background: white; border-radius: 20px; box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1); overflow: hidden;">
        <div style="background: linear-gradient(135deg, var(--primary) 0%, #1e40af 100%); padding: 2rem; text-align: center; color: white;">
            <div style="font-size: 4rem; margin-bottom: 1rem;">
                <i class="fas fa-book-open"></i>
            </div>
            <h2 style="margin-bottom: 0.5rem; font-size: 1.8rem; font-weight: 700;">BiblioTech</h2>
            <p style="opacity: 0.9; font-size: 1rem;">Sistema de Gestión Bibliotecaria</p>
        </div>
        
        <div style="padding: 2.5rem;">
            <div style="text-align: center; margin-bottom: 2rem;">
                <h3 style="color: var(--dark); font-size: 1.5rem; font-weight: 600; margin-bottom: 0.5rem;">Iniciar Sesión</h3>
                <p style="color: var(--secondary); font-size: 0.9rem;">Accede a tu cuenta</p>
            </div>

            <form method="POST" action="{{ route('login') }}">
                @csrf
                
                <div style="margin-bottom: 1.5rem;">
                    <label for="email" style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: var(--dark);">Correo Electrónico</label>
                    <div style="position: relative;">
                        <i class="fas fa-envelope" style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: var(--secondary);"></i>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               style="width: 100%; padding: 1rem 1rem 1rem 3rem; border: 2px solid var(--border); border-radius: 12px; font-size: 1rem; transition: all 0.3s;" 
                               value="{{ old('email') }}" 
                               required 
                               autofocus
                               placeholder="tu@email.com">
                    </div>
                    @error('email')
                        <div style="color: var(--danger); font-size: 0.875rem; margin-top: 0.5rem; display: flex; align-items: center; gap: 0.5rem;">
                            <i class="fas fa-exclamation-circle"></i>{{ $message }}
                        </div>
                    @enderror
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label for="password" style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: var(--dark);">Contraseña</label>
                    <div style="position: relative;">
                        <i class="fas fa-lock" style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: var(--secondary);"></i>
                        <input type="password" 
                               id="password" 
                               name="password" 
                               style="width: 100%; padding: 1rem 1rem 1rem 3rem; border: 2px solid var(--border); border-radius: 12px; font-size: 1rem; transition: all 0.3s;" 
                               required
                               placeholder="••••••••">
                    </div>
                    @error('password')
                        <div style="color: var(--danger); font-size: 0.875rem; margin-top: 0.5rem; display: flex; align-items: center; gap: 0.5rem;">
                            <i class="fas fa-exclamation-circle"></i>{{ $message }}
                        </div>
                    @enderror
                </div>

                <div style="margin-bottom: 2rem; display: flex; align-items: center; gap: 0.5rem;">
                    <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} style="width: 1.2rem; height: 1.2rem;">
                    <label for="remember" style="color: var(--secondary); font-size: 0.9rem;">Recordarme</label>
                </div>

                <button type="submit" style="width: 100%; background: linear-gradient(135deg, var(--primary) 0%, #1e40af 100%); color: white; padding: 1rem; border: none; border-radius: 12px; font-size: 1rem; font-weight: 600; cursor: pointer; transition: all 0.3s; margin-bottom: 1.5rem;">
                    <i class="fas fa-sign-in-alt" style="margin-right: 0.5rem;"></i>
                    Iniciar Sesión
                </button>
            </form>

            <div style="text-align: center; padding-top: 1.5rem; border-top: 1px solid var(--border);">
                <p style="color: var(--secondary); margin-bottom: 1rem; font-size: 0.9rem;">¿No tienes una cuenta?</p>
                <a href="{{ route('register') }}" style="display: inline-flex; align-items: center; gap: 0.5rem; color: var(--primary); text-decoration: none; font-weight: 600; transition: all 0.3s;">
                    <i class="fas fa-user-plus"></i>
                    Crear Cuenta
                </a>
            </div>
        </div>
    </div>
</div>

<style>
input:focus {
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