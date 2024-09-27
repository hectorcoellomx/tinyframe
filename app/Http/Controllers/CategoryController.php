<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function category(){
        $catalogo = Category::all();
        if ($catalogo){
            return response()->json([
                'success' => true,
                'data' => $catalogo,
                'message' => "OK"
            ]);
        }else
        {
            return response()->json([
                "success" => false,
                "data" => null,
                'message' => "No existe datos",
                'error' => [
                    'code' => 401,
                    'details' => "No existe datos",
                ]
            ], 401);
        }
    }
}
