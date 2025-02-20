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
                'data' => $collection,
                'message' => "OK",
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

    public function create(){
        return view('collections.create');
    }

    public function index(){
        $collections = Collection::all();
        return view('collections.index', compact('collections'));
    }

    public function show(){
        return view('collections.show');
    }
}
