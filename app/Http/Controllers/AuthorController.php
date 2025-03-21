<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function Author(){
        $author = Author::all();

        if($author){
            return response()->json([
                'success' => true,
                'data' => $author,
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
        return view('authors.create');
    }
    public function store(Request $request)
    {
        try {
             
        $validatedData = $request->validate([
            'name' => 'required|string|max:200',
        ]);
        //dd( $validatedData);


        } catch (\Illuminate\Validation\ValidationException $e) {
            dd($e->errors());

        }
        // $coverPhotoPath = $request->file('cover_photo')->store('covers', 'public');
        // $filePath = $request->file('file')->store('files', 'public');
        try {

        $author = Author::create([
            'name' => $request->name,
            
        ]);

        //dd($book);

        return redirect('/authors')->with('success', 'Autor creado exitosamente.');

        }  catch (\Exception $e) {
            dd('Error: ' . $e->getMessage());
        }
       
        

    }

    public function index(){
        //$authors = Author::orderby('id')->get();
        $authors = Author::orderBy('name', 'asc')->paginate(3);
        return view('authors.index',compact('authors'));
    }

    public function show($author){
        $author = Author::find($author);
        return view('authors.show',compact('author'));
    }

    public function edit($author){
        $author = Author::find($author);
        return view('authors.edit',compact('author'));
    }
    public function update(Request $request, $author)
{
    try {
        $validatedData = $request->validate([
            'name' => 'sometimes|string|max:200',
            
        ]);
    } catch (\Illuminate\Validation\ValidationException $e) {
        return redirect()->back()->withErrors($e->errors())->withInput();
    }

    // Buscar el libro a actualizar
    $author = Author::findOrFail($author);

    try {
        
        // Actualizar los demás campos
        $author->name = $request->name;
        // Guardar los cambios en la base de datos
        $author->save();

        // Redirigir con un mensaje de éxito
        return redirect("/authors/{$author->id}")->with('success', 'Autor actualizado exitosamente.');
    } catch (\Exception $e) {
        // Manejar cualquier error inesperado
        return redirect()->back()->with('error', 'Ocurrió un error al actualizar el libro: ' . $e->getMessage());
    }
}

    public function destroy($author){
        $author = Author::find($author);
        $author->delete();
        return redirect('/authors');
    }
}
