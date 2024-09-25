<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:200',
            'email' => 'required|string|email|max:80|unique:users',
            'type' => 'required|boolean',
            'last_access' => 'required|date',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => "Error en la validación",
                "errors" => $validator->errors(),
            ], 422);
        }
    
        try {
            $validatedData = $validator->validated();
    
            $user = new User();
            $user->name = $validatedData['name'];
            $user->email = $validatedData['email'];
            $user->type = $validatedData['type'];
            $user->last_access = $validatedData['last_access'];
    
            if ($user->save()) {
                return response()->json([
                    "success" => true,
                    "data" => $user,
                    'message' => 'Usuario creado correctamente',
                ], 201);
            } else {
                return response()->json([
                    "success" => false,
                    "data" => null,
                    'message' => 'No se pudo crear el usuario',
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "data" => null,
                'message' => "Ha ocurrido un error inesperado",
                'error' => [
                    'code' => $e->getCode(),
                    'details' => $e->getMessage(),
                ]
            ], 500);
        }
    }
}
