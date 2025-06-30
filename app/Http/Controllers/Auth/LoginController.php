<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        
        // Buscar usuario por email
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
        
        // Para este ejemplo, usamos el email como password
        // En producción deberías usar Hash::check()
        if ($credentials['password'] === 'bibliotech2024') {
            Auth::login($usuario);
            
            return redirect()->intended(route('dashboard'))
                ->with('success', '¡Bienvenido de vuelta!');
        }
        
        return back()->withErrors([
            'password' => 'La contraseña es incorrecta.'
        ]);
    }
    
    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('login')
            ->with('success', 'Has cerrado sesión correctamente.');
    }
}
