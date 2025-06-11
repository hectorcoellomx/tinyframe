<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use Illuminate\Http\Request;
use Termwind\Components\Raw;

class RatingController extends Controller
{
    public function store(Request $request, $id){
        
        try{
            $validated = $request->validate([
                'point' => 'required|integer|between:1,5',
                'user_id' => 'required|exists:users,id',
            ]);

            //validador de integridad
           $existingRating = Rating::where('book_id', $id) -> where('user_id', $validated['user_id'])->first();

           if ($existingRating){
            $existingRating->update([
                'point'=> $validated['point']
            ]);

            return response()->json([
                "message"=> "Rating updated successfully",
                "data"=> $existingRating
            ],200);
           }else {
                $newRating = Rating::create([
                    'point' => $validated['point'],
                    'book_id' => $id,
                    'user_id' => $validated['user_id']
                ]);
           }

            return response()->json([
                "success" => true,
                "message" => "Rating created successfully",
                "data" => $newRating
            ]);
            
            if ($validated->fails()) {
                return response()->json([
                    "success" => false,
                    "message" => "Error de validación",
                    "errors" => $rating->errors()
                ], 400);
            }

        }catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "message" => "Ocurrió un error",
                "error" => $e->getMessage()
            ], 500);

        }
    }

    
}
