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

    public function create (){
        return view('categories.create');
    }
    public function store(Request $request){
        try {
            $validateData= $request->validate([
                'name' => 'required|string|max:100',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            dd($e->errors());
        }

        try {
            $category = Category::create([
                'name' => $request->name,
            ]);

        return redirect()->route('categories.index')->with('succes', 'Categoria creada exitosamente');
        } catch (\Exception $e) {
            ;
        }
    }

    public function index(){
        $categories = Category::orderBy('name', 'asc')->paginate(10);
        return view('categories.index', compact('categories'));
    }
    public function show ($category){
        $category = Category::find($category);
        return view('categories.show', compact('category'));
    }

    public function edit($category){
        $category = Category::find($category);
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, $category){
        try {
            $validatedData = $request->validate([
                'name' => 'sometimes|string|max:200'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
            //throw $th;
        }
        $category = Category::findOrFail($category);

        $category->name = $request->name;

        $category->save();

        return redirect()->route('categories.show', $category->id)->with('succes', 'Categoría actualizada');

    }

    public function destroy($category){
        $category = Category::find($category);
        $category->delete();
        return redirect()->route('categories.index')->with('succes', 'Se elimino la categoria');
    }

}
