<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $users = [
            ['email' => 'claudia.ramos@unach.mx', 'type' => 3 ], 
            ['email' => 'hector.coello@unach.mx', 'type' => 3 ], 
            ['email' => 'gabriel.velazquez@unach.mx', 'type' => 3 ], 
            [
                'email' => 'georgina.mendez60@unach.mx',
                //'password' => 'admin', // Contraseña en texto plano (solo para este ejemplo)
                'type' => 3, // Tipo de usuario (3 = administrador)
            ],
        ];

        $user = collect($users)->firstWhere('email', $request->email);

        if ($user && $user['email'] === $request->email) {
            session(['user' => $user]);
            return redirect('/users');
        }

        return back()->withErrors([
            'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ]);
    }

    public function logout(Request $request)
    {
        $request->session()->forget('user');
        return redirect('/login');
    }
}