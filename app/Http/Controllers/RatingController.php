<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function store(Request $request, $id){
        try{
            $advance = Rating::findOrFail($id);

            $validator = Rating::make($request->all(), [
                'point' => 'required|string|max:50',
                'book_id' => 'required|integer',
                'user_id' => 'required|integer|in:1,2',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    "success" => false,
                    "message" => "Error de validación",
                    "errors" => $validator->errors()
                ], 400);
            }

            $data = $request->all();

            $advance = new Rating();
            $advance->fill($data);
            $advance->save();
            
            return response()->json([
                "success" => true,
                "message" => "Registro actualizado correctamente",
                "data" => $advance
            ], 200);

        }catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "message" => "Ocurrió un error",
                "error" => $e->getMessage()
            ], 500);

        }
    }
    public function update(){

    }
}
