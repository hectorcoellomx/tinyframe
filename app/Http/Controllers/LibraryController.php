<?php

namespace App\Http\Controllers;

use App\Models\users;
use GuzzleHttp\Psr7\Message;
use Illuminate\Http\Request;

use function Laravel\Prompts\error;

class LibraryController extends Controller
{
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'email' => 'required|email',
                'name' => 'required|max:200',
                'type' => 'required|integer',
                'last_access' => 'required|date',
            ]);
    
            $user = Users::create($validated);
    
            return response()->json([
                "success" => true,
                "data" => $user,
                'message' => 'ok',
            ], 201);
    
        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "data" => null,
                'message' => "ha ocurrido un error inesperado",
                'error' => [
                    'code' => "...",
                    'details' => "Error de conexión bd"
                ]
            ], 500);
        }
    }
}
