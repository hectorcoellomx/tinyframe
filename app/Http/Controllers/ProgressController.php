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
                'status' => 'required|integer|in:1,2',
                'position' => 'required|integer|min:1|max:100',
            ]);

            if ($validator->failed()) { // Cambiado a fails()
                return response()->json([
                    "success" => false,
                    "message" => "Error de validación",
                    "error" => [
                        'code' => 400,
                        'message' => 'Error de validación',
                        'details' => $validator->errors()->first(), // Corregido 'datails' a 'details'
                    ]
                ]);
            }
                $advance = new Progress();
                $advance->book_id  = $request->book_id;
                $advance->user_id = $request->user_id;
                $advance->status = $request->status;
                $advance->position = $request->position;
                $advance->save();

        
            if($advance->save())
           {
                return response()->json([
                    "success" => true,
                    "message" => 'OK',
                    "data" => $advance
                ]);
           }else {
                return response()->json([
                    'success' => false,
                    'message' => 'Error saving progress record',
                ], 500);
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

    public function update(Request $request, $id)
    {
        try{
            $advance = Progress::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'book_id' => 'required|string|max:50',
                'user_id' => 'required|integer',
                'status' => 'required|integer|in:1,2',
                'position' => 'required|integer|min:1|max:100',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    "success" => false,
                    "message" => "Error de validación",
                    "errors" => $validator->errors()
                ], 400);
            }
            $advance->update($request->all());

            return response()->json([
                "success" => true,
                "message" => "Registro actualizado correctamente",
                "data" => $advance
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "message" => "Ocurrió un error",
                "error" => $e->getMessage()
            ], 500);
        }
    }    
}
