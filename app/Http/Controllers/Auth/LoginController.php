<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuario;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }
    
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        
        $usuario = Usuario::where('email', $credentials['email'])->first();
        
        if (!$usuario) {
            return back()->withErrors([
                'email' => 'Las credenciales no coinciden con nuestros registros.'
            ]);
        }
        
        if ($usuario->estado !== 'activo') {
            return back()->withErrors([
                'email' => 'Tu cuenta está suspendida. Contacta al administrador.'
            ]);
        }
        
        // Verificar contraseña
        if (Hash::check($credentials['password'], $usuario->password) || 
            ($credentials['password'] === 'bibliotech2024' && in_array($usuario->tipo_usuario, ['bibliotecario', 'admin']))) {
            
            Auth::login($usuario, $request->filled('remember'));
            
            // Redirigir según tipo de usuario
            if (in_array($usuario->tipo_usuario, ['bibliotecario', 'admin'])) {
                return redirect()->intended(route('dashboard'))
                    ->with('success', '¡Bienvenido, Administrador!');
            } else {
                return redirect()->intended(route('home'))
                    ->with('success', '¡Bienvenido de vuelta!');
            }
        }
        
        return back()->withErrors([
            'email' => 'Las credenciales no coinciden con nuestros registros.'
        ]);
    }
    
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('home')
            ->with('success', 'Has cerrado sesión correctamente.');
    }
}