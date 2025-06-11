<?php

namespace App\Http\Controllers;

use App\Models\Progress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProgressController extends Controller
{
    public function store(Request $request){

       try{
            $validator = Validator::make($request->all(), [
                'book_id' => 'required|string|max:50',
                'user_id' => 'required|integer',
                'position' => 'required|integer|min:0|max:100',
            ]);

            if ($validator->failed()) { // Cambiado a fails()
                return response()->json([
                    "success" => false,
                    "data" => null,
                    "message" => "Error de validación",
                    "error" => [
                        'code' => 400,
                        'message' => 'Error de validación',
                        'details' => $validator->errors()->first(), // Corregido 'datails' a 'details'
                    ]
                ]);
            }

            $progress = Progress::where('book_id', $request->input('book_id'))
                    ->where('user_id', $request->input('user_id'))
                    ->first();

            if ($progress) {
   
                $status = ($request->position != 100 && $progress->status == 1) ? 1 : 2;

                $progress->status = $status;
                $progress->position = $request->position;
                $progress->save();
                
                return response()->json([
                    "success" => true,
                    "message" => 'OK',
                    "data" => null
                ]);

            }else{
                
                $status = ($request->position == 100) ? 2 : 1;

                $progress = new Progress();
                $progress->book_id  = $request->book_id;
                $progress->user_id = $request->user_id;
                $progress->status = $status;
                $progress->position = $request->position;
                $progress->save();

            
                if($progress->save())
                {
                    return response()->json([
                        "success" => true,
                        "message" => 'OK',
                        "data" => null
                    ]);
                }else {
                    return response()->json([
                        "success" => false,
                        "data"=> null,
                        "message" => "Error del servidor",
                        'error' => [
                                'code' => 500,
                                'message' => 'server error',
                                'details' => $validator->errors()->first(),
                                ]
                    ], 500);
                }
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
