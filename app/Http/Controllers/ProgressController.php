<?php

namespace App\Http\Controllers;

use App\Models\Progress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProgressController extends Controller
{
    public function progressBook(Request $request){

       try{
            $validator = Validator::make($request->all(), [
                'book_id' => 'required|string|max:50',
                'user_id' => 'required|integer',
                'status' => 'required|in:1,2',
                'position' => 'required|integer|min:1|max:100',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    "success" => false,
                    "message" => "Error en la validación",
                    'error' => [
                    'code' => 400,
                            'message' => 'Error en la validación',
                            'details' => $validator->errors()->first(),
                            ]
                ]);
            }
            $progress = new Progress();
            $progress->book_id = $request->book_id;
            $progress->user_id = $request->user_id;
            $progress->status = $request->status;
            $progress->position = $request->position;

           if($progress->save())
           {
            return response()->json([
                'success' => true,
                'data' => $progress,
                'message' => 'OK'
            ]);
           }else
           {
            return response()->json([
                'sucess' => false,
                "data" => null,
                "message" => 'No es posible guardar progreso'
            ]);
           }

        }catch (\Exception $e) {
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
