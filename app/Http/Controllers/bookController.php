<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Author;
use Illuminate\Support\Facades\Storage;
use App\Models\Progress;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use ePub;

use function Laravel\Prompts\error;

class bookController extends Controller
{
    
    public function book(Request $request)
    {
        try {
            $filter = $request->query('filter');
            $value = $request->query('value');
            
            $options = array("category", "collection", "shelving", "most_read", "search");
            $books = null;
            $result = null;
            
            if ( in_array($filter, $options) && (($filter!="most_read" && $value) || $filter=="most_read" ) ) {

                $books = Book::query();

                switch ($filter) {
                    case 'category':
                        $books->whereHas('categories', function ($query) use ($value) {
                            $query->where('category_id', $value);
                        });
                        break;
    
                    case 'collection':
                        $books->whereHas('collections', function ($query) use ($value) {
                            $query->where('collection_id', $value);
                        });
                        break;
    
                    case 'shelving':
                        $books->whereHas('shelving', function ($query) use ($value) {
                            $query->where('user_id', $value);  // Filtrar por el ID del usuario que añadió el libro a su estantería
                        });
                        break;
    
                    case 'most_read':
                        $result = Book::most_read();
                    case 'search':
                        $keywords = explode(' ', trim($value)); // Dividir el valor en palabras con la funcion explode eliminando espacios en blanco

                        $books->where(function ($query) use ($keywords) {
                            foreach ($keywords as $word) {
                                $query->where(function ($subQuery) use ($word) {
                                    $subQuery->where('keywords', 'LIKE', '%' . $word . '%')
                                            ->orWhere('title', 'LIKE', '%' . $word . '%');
                                });
                            }
                        });
                    break;
                }

                $books = ($filter!="most_read") ? $books->get() : $result;
    
                return response()->json([
                    "success" => true,
                    "data" => $books,
                    "message" => "OK"
                ]
                );
                
            }else{
                return response()->json([
                    "success" => false,
                    "data" => null,
                    'message' => "Invalid params",
                    'error' => [
                        'code' => 400,
                        'details' => "Invalid params",
                    ]
                ], 400);

            }

        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "data" => null,
                'message' => "Ha ocurrido un error inesperado",
                'error' => [
                    'code' => $e->getCode(),
                    'message' => 'Error del servidor',
                    'details' => $e->getMessage(),
                ]
            ], 500);
        }
       
    }

    public function show($id, $user_id)
    {

        try{

        $averageData = Book::average($id, $user_id);

        if ($averageData) {
            return response()->json([
                "success" => true,
                'message' => 'OK',
                "data"=> $averageData
            ],200);
        } 

        return response()->json([
            "success" => false,
            "message" => "Ha ocurrido un error",
            'error' => [
                    'code' => 404,
                    'message' => 'data does not exist',
                    'details' => 'data does not exist',
                    ]
            ], 404);
        }catch(\Exception $e){
            return response()->json([
                "success" => false,
                "message" => "Ha ocurrido un error inesperado",
                'error' => [
                    'code' => 500,
                    'message' => 'Error interno del servidor',
                    'details' => $e->getMessage(), 
                ]
            ], 500);
        }
    }
    public function create(){
        $collections = Collection::all();
        $categories = Category::all();
        $authors = Author::all();
        return view('books.create',compact('collections', 'categories', 'authors'));
    }
    // public function store(Request $request)
    // {
    //     // dd($request->all());
    //     try {
             
    //     $validatedData = $request->validate([
    //         'title' => 'required|string|max:200',
    //         'cover_photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
    //         'description' => 'required|string|max:900',
    //         'file' => 'required|mimes:epub|max:10000',
    //         'year' => 'required|integer|min:1900|max:' . date('Y'),
    //         'keywords' => 'required|string|max:200',
    //         'author_ids' => 'required|array', // Validar que se envíen autores
    //         'collection_ids' => 'required|array', // Validar que se envíen categorías
    //     ]);
    //     //dd( $validatedData);


    //     } catch (\Illuminate\Validation\ValidationException $e) {
    //         dd($e->errors());

    //     }
    //     // $coverPhotoPath = $request->file('cover_photo')->store('covers', 'public');
    //     // $filePath = $request->file('file')->store('files', 'public');
    //     try {
    //         $coverPhotoPath = $request->file('cover_photo')->store('covers', 'public');
    //     $filePath = $request->file('file')->store('files', 'public');
        

    //     $book = Book::create([
    //         'id' => Str::uuid(),
    //         'title' => $request->title,
    //         'cover_photo' => $coverPhotoPath,
    //         'description' => $request->description,
    //         'file' => $filePath,
    //         'year' => $request->year,
    //         'keywords' => $request->keywords,
    //         'status' => 1,
    //     ]);

    //     //dd($book);

    //     return redirect('/books')->with('success', 'Libro creado exitosamente.');

    //     }  catch (\Exception $e) {
    //         dd('Error: ' . $e->getMessage());
    //     }

    //      // Asociar el libro con autores
    //      $book->authors()->attach($request->author_ids);

    //      // Asociar el libro con categorías
    //      $book->categories()->attach($request->category_ids);
 
    //      // Asociar el libro con colecciones
    //      $book->collections()->attach($request->collection_ids);
       
        

    // }

    public function store(Request $request)
{
    try {
        
        $validatedData = $request->validate([
            'title' => 'required|string|max:200',
            'cover_photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'description' => 'required|string|max:900',
            'file' => 'required|mimes:epub|max:10000',
            'year' => 'required|integer|min:1900|max:' . date('Y'),
            'keywords' => 'required|string|max:200',
            'author_ids' => 'required|array', // Validar que se envíen autores
            'category_ids' => 'required|array',// Validar que se envíen categorías
            'collection_ids' => 'required|array', // Validar que se envíen colecciones
        ]);

        // Guardar la imagen de portada y el archivo
        $coverPhotoPath = $request->file('cover_photo')->store('covers', 'public');
        $filePath = $request->file('file')->store('files', 'public');

        // Crear el libro
        $book = Book::create([
            'id' => Str::uuid(),
            'title' => $request->title,
            'cover_photo' => $coverPhotoPath,
            'description' => $request->description,
            'file' => $filePath,
            'year' => $request->year,
            'keywords' => $request->keywords,
            'status' => 1,
        ]);

        // Asociar el libro con autores, categorías y colecciones
        $book->authors()->attach($request->author_ids);
        $book->categories()->attach($request->category_ids);
        $book->collections()->attach($request->collection_ids);

        return redirect('/books')->with('success', 'Libro creado exitosamente.');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Ocurrió un error: ' . $e->getMessage());
    }
}
    // public function index(){


    //     $books = Book::orderBy('title', 'asc')->paginate(3); // Obtener todos los libros
    //     return view('books.index', compact('books'));
    // }

    public function index()
    {
        try {
            // Obtener los libros con su calificación promedio
            $books = DB::table('books')
                ->leftJoin('ratings', 'books.id', '=', 'ratings.book_id')
                ->select(
                    'books.*',
                    DB::raw('IFNULL(AVG(ratings.point), 0) as calificacion') // Calcular el promedio
                )
                ->groupBy('books.id') // Agrupar por libro
                ->paginate(10); // Paginación

            return view('books.index', compact('books'));
        } catch (\Exception $e) {
            // Manejar errores
            return redirect()->back()->with('error', 'Ha ocurrido un error inesperado: ' . $e->getMessage());
        }
    }

   

    public function ver($book){
        // $collections = Collection::all();
        // $book = Book::find($book);
        $book = Book::with('authors','collections')->findOrFail($book);
        //return $book;
        return view('books.show',compact('book', 'collections'));
    }

    public function leerEpub(Book $book)
    {
        $archivo = basename($book->file);
        return view('epub.lector-epub', compact('archivo'));
        // $book = Book::findOrFail($id);
        // $archivo = basename($book->file); // nombre de archivo como 'milibro.epub'
    
        // return view('epub.lector-epub', compact('archivo'));
        // $book = Book::findOrFail($id); // Asume modelo Book
        
        // // Verifica que el archivo exista
        // if (!Storage::disk('public')->exists("files/{$book->file}")) {
        //     abort(404);
        // }

        

        // return view('epub.lector-epub', [
        //     'book' => $book,
        //     'epubUrl' => asset("storage/files/{$book->file}")
        // ]);
    }

    public function edit($book){
        $collections = Collection::all();
        $book = Book::find($book);
        $authors = Author::all();
        $categories = Category::all();
        //Pasar colecciones, autores y categorías 
        $selectedCollections = $book->collections->pluck('id')->toArray();
        $selectedAuthors = $book->authors->pluck('id')->toArray();
        $selectedCategories = $book->categories->pluck('id')->toArray();
        return view('books.edit', compact('book', 'collections', 'authors', 'categories', 'selectedCollections', 'selectedAuthors', 'selectedCategories'));
    }
    public function update(Request $request, $book)
    {
        try {
            // Validación de datos (campos opcionales para archivos)
            $validatedData = $request->validate([
                'title' => 'required|string|max:200',
                'cover_photo' => 'sometimes|image|mimes:jpeg,png,jpg|max:2048', // Opcional
                'description' => 'required|string|max:900',
                'file' => 'sometimes|mimes:epub|max:10000', // Opcional
                'year' => 'required|integer|min:1900|max:' . date('Y'),
                'keywords' => 'required|string|max:200',
                'author_ids' => 'required|array', // Validar que se envíen autores
                'category_ids' => 'required|array', // Validar que se envíen categorías
                'collection_ids' => 'required|array', // Validar que se envíen colecciones
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        }

        // Buscar el libro a actualizar
        $book = Book::findOrFail($book);

        try {
            // Procesar la imagen de portada si se subió una nueva
            if ($request->hasFile('cover_photo')) {
                // Eliminar la imagen anterior si existe
                if ($book->cover_photo && Storage::disk('public')->exists($book->cover_photo)) {
                    Storage::disk('public')->delete($book->cover_photo);
                }
                // Guardar la nueva imagen
                $coverPhotoPath = $request->file('cover_photo')->store('covers', 'public');
                $book->cover_photo = $coverPhotoPath;
            }

            // Procesar el archivo PDF si se subió uno nuevo
            if ($request->hasFile('file')) {
                // Eliminar el archivo anterior si existe
                if ($book->file && Storage::disk('public')->exists($book->file)) {
                    Storage::disk('public')->delete($book->file);
                }
                // Guardar el nuevo archivo
                $filePath = $request->file('file')->store('files', 'public');
                $book->file = $filePath;
            }

            // Actualizar los demás campos
            $book->title = $request->title;
            $book->description = $request->description;
            $book->year = $request->year;
            $book->keywords = $request->keywords;

            // Guardar los cambios en la base de datos
            $book->save();

            $book->authors()->sync($request->author_ids);
            $book->categories()->sync($request->category_ids);
            $book->collections()->sync($request->collection_ids);


            // Redirigir con un mensaje de éxito
            return redirect("/books/{$book->id}")->with('success', 'Libro actualizado exitosamente.');
        } catch (\Exception $e) {
            // Manejar cualquier error inesperado
            return redirect()->back()->with('error', 'Ocurrió un error al actualizar el libro: ' . $e->getMessage());
        }
    }
    public function destroy($book){
        $book = Book::find($book);
        $book->delete();
        return redirect('/books');
    }
    
}

