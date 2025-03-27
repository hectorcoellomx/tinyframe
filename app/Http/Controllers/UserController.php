<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
    // public function login(Request $request)
    // {
    //     $credentials = $request->only(['name','email']);

    //     $user = User::where('name', $credentials['name'])
    //                 ->where('email', $credentials['email'])
    //                 ->first();

    //     if(! $user) {
    //         return response()->json(['error' => 'Unauthorized'], 401);
    //     }
    //     $token = JWTAuth::fromUser($user);
    //     return $this->respondWithToken($token);
    // }
    // public function me()
    // {
    //     $user = JWTAuth::parseToken()->authenticate();

    //     return response()->json($user);
    // }

    // public function logout()
    // {
    //     Auth::logout();
    //     return response()->json(['message' => 'Successfully logged out']);
    // }

    // public function refresh()
    // {
    //     return $this->respondWithToken (Auth::refresh());
    // }

    // protected function respondWithToken($token)
    // {
    //     return response()->json([
    //         'token_type' => 'bearer',
    //         'access_token'=> $token,
    //         'expires_in' => Auth::factory()->getTTL() * 60
    //     ]);
    // }

    // Mostrar listado de usuarios
    public function index()
    {
        //$users = User::all();
        $users = User::orderBy('name', 'asc')->paginate(10);
        return view('users.index', compact('users'));
    }
    

    // Mostrar formulario para crear un usuario
    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:200',
            'email' => 'required|string|email|max:80',
            'type' => 'required|in:0,1,2,3',
            'last_access' => 'required|date',
        ]);

        $validator->sometimes('email', 'regex:/^[a-zA-Z0-9.]+@unach\.mx$/i', function ($input) {
            return in_array($input->type, [1, 2, 3]);
        });

    
        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "data"=> null,
                "message" => "Error en la validación",
                'error' => [
                        'code' => 400,
                        'message' => 'Error en la validación',
                        'details' => $validator->errors()->first(),
                        ]
            ], 400);
        }
    
        try {
            $validatedData = $validator->validated();
            $validatedData ['email'] = strtolower($validatedData['email']);

            $user = User::where('email', $request->input('email'))->first();

            if ($user) {
                $user->last_access = $request->input('last_access');
                $user->save();
    
                return response()->json([
                    'success' => true,
                    'data'=> $user,
                    'message' => 'OK'
                ], 201);
            } else {
                $user = new User();
                $user->name = $validatedData['name'];
                $user->email = $validatedData['email'];
                $user->type = $validatedData['type'];
                $user->last_access = $validatedData['last_access'];
        
                if ($user->save()) {
                    return response()->json([
                        "success" => true,
                        "data" => $user,
                        'message' => 'OK',
                    ], 201);
                } else {
                    return response()->json([
                        "success" => false,
                        "data" => null,
                        'message' => 'Ha ocurrido un error inesperado',
                        'error' => [
                                'code' => 500,
                                'message' => 'No se ha creado el usuario',
                                'details' => "Error del servidor",
                        ]
                    ], 500);
                }
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
