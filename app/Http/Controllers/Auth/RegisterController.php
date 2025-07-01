<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }
    
    public function register(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'email' => 'required|email|unique:usuarios,email',
            'codigo_estudiante' => 'nullable|string|max:20|unique:usuarios,codigo_estudiante',
            'telefono' => 'nullable|string|max:20',
            'tipo_usuario' => 'required|in:estudiante,profesor',
            'password' => 'required|string|min:6|confirmed'
        ]);
        
        $usuario = Usuario::create([
            'nombre' => $validated['nombre'],
            'apellido' => $validated['apellido'],
            'email' => $validated['email'],
            'codigo_estudiante' => $validated['codigo_estudiante'],
            'telefono' => $validated['telefono'],
            'tipo_usuario' => $validated['tipo_usuario'],
            'password' => Hash::make($validated['password']),
            'estado' => 'activo',
            'fecha_registro' => now()
        ]);
        
        Auth::login($usuario);
        
        return redirect()->route('home')
            ->with('success', '¡Registro exitoso! Bienvenido a BiblioTech.');
    }
}