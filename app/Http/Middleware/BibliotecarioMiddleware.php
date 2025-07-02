<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BibliotecarioMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        $user = Auth::user(); // Cambiar de Auth::Usuario() a Auth::user()
        
        if (!in_array($user->tipo_usuario, ['bibliotecario', 'admin'])) {
            return redirect()->route('home')
                ->with('error', 'No tienes permisos para acceder a esta sección. Solo administradores.');
        }
        
        return $next($request);
    }
}