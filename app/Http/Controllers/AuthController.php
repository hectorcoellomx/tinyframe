<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    // Mostrar el formulario de login
    public function login()
    {
        return view('auth.login');
    }

    // Manejar la autenticación
    public function authenticate(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'email' => 'required|email',
        ]);

        // Array de usuarios permitidos
        $users = [
            [
                'email' => 'georgina.mendez60@unach.mx',
                //'password' => 'admin', // Contraseña en texto plano (solo para este ejemplo)
                'type' => 3, // Tipo de usuario (3 = administrador)
            ],
            // Puedes agregar más usuarios aquí si lo necesitas
        ];

        // Buscar el usuario en el array
        $user = collect($users)->firstWhere('email', $request->email);

        // Verificar si el usuario existe y la contraseña coincide
        if ($user && $user['email'] === $request->email) {
            // Guardar el usuario en la sesión
            session(['user' => $user]);

            // Redirigir a la vista index.blade.php en la carpeta users
            return redirect('/users');
        }

        // Si la autenticación falla, redirigir con un mensaje de error
        return back()->withErrors([
            'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ]);
    }

    // Cerrar sesión
    public function logout(Request $request)
    {
        // Eliminar el usuario de la sesión
        $request->session()->forget('user');

        // Redirigir al login
        return redirect('/login');
    }
}