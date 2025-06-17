<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{

    // Mostrar listado de usuarios
    public function index()
    {
        //$users = User::all();
        $users = User::orderBy('name', 'asc')->paginate(10);
        return view('users.index', compact('users'));
    }

    public function login()
    {
        $user = array("id" => 10, "name" => "Juan Pérez", "email" => "juanito@unach.mx");

        return response()->json([
            "success" => true,
            "data" => $user,
            "message" => "OK"
        ]
        );
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
            'type' => 'required|in:0,1,2,3'
        ]);

        if(strpos($request->input('email'), "@unach.mx")!== false && $request->input('type')==0){
            return response()->json([
                "success" => false,
                "data"=> null,
                "message" => "Si tienes un correo UNACH, no debes ingresar como invitado",
                'error' => [
                        'code' => 400, 
                        'details' => "",
                        ]
            ], 400);
        }
    
        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "data"=> null,
                "message" => "Los datos ingresados son inválidos",
                'error' => [
                        'code' => 400, 
                        'details' => $validator->errors()->first(),
                        ]
            ], 400);
        }
    
        try {
            $validatedData = $validator->validated();
            $validatedData['email'] = strtolower($validatedData['email']);

            $user = User::where('email', $request->input('email'))->first();

            if ($user) {

                $user->last_access = date("Y-m-d h:i:s");
                $user->save();
    
                return response()->json([
                    'success' => true,
                    'data'=> $user,
                    'message' => 'OK'
                ], 201);

            } else {
                
                $user = new User();
                $user->name = $request->input('name');
                $user->email = $request->input('email');
                $user->type = $request->input('type');
                $user->last_access = date("Y-m-d h:i:s");
        
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
