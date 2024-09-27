<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use Illuminate\Http\Request;

use function Pest\Laravel\json;

class CollectionController extends Controller
{
    public function collection(){
        $collection = Collection::all();

        if($collection){
            return response()->json([
                'success' => true,
                'message' => "OK",
                'data' => $collection,
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
