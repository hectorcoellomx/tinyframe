<?php

namespace App\Http\Controllers;

use App\Models\users;
use Illuminate\Http\Request;

class LibraryController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'name' => 'required|max:200',
            'type' => 'required|integer',
            'last_access' => 'required|date',
        ]);

        $user = users::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'type' => $request->input('type'),
            'last_access' => $request->input('last_access')
        ]);

        return response()->json([
            'message' => 'Usuario creado exitosamente',
            'user' => $user
        ], 201);
    }
}
