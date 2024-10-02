<?php

namespace App\Http\Controllers;

use App\Models\Shelvings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ShelvesController extends Controller
{
    public function store(Request $request){
    
        try{
            $validator = Validator::make($request->all(), [
                'book_id' => 'required|string|max:50',
                'user_id' => 'required|integer',
            ]);

            if($validator->failed()){
                return response()->json([
                    "success" => false,
                    "data" => null,
                    "message" => "Error de validación",
                    "error" => [
                            'code' => 400,
                            'message' => 'Error de validación',
                            'datails'=> $validator->errors()->first(),
                    ]
                ], 400);
            }
            $Shelve = new Shelvings();
            $Shelve->book_id = $request->book_id;
            $Shelve->user_id = $request->user_id;

            if($Shelve->save())
            {
                return response()->json([
                    "success" => true,
                    "message" => "OK",
                    "data" => $Shelve
                ]);
            }
    
        }catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "data" => null,
                'message' => "Ha ocurrido un error inesperado",
                'error' => [
                    'code' => $e->getCode(),
                    'message' => 'server error',
                    'details' => $e->getMessage(),
                ]
            ], 500);
        }
     
    
    }
   
}
