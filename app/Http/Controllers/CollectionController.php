<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use App\Http\Controllers\Response;
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
    public function store(Request $request){
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:200'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            dd($e->errors());
        }

        try {
            $collection = Collection::create(
                [
                    'name'=> $request->name
                ]
                );
        return redirect('/collections')->with('success','Categoria creada exitosamente');
        } catch (\Exception $e) {
            dd('Error: '. $e->getMessage());
        }
    }

    public function index(){
        $collections = Collection::all();
        return view('collections.index', compact('collections'));
    }

    public function show($collection){
        $collection = Collection::find($collection);
        return view('collections.show', compact('collection'));
    }
}
