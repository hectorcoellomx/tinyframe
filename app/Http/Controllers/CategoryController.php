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
                'message' => "No data available",
                'error' => [
                    'code' => 404,
                    'details' => "No data available",
                ]
            ], 404);
        }
    }
}
