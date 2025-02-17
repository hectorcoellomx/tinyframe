<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Progress;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        return view('books.create');
    }
    public function index(){
        $books = Book::all(); // Obtener todos los libros
        return view('books.index', compact('books'));
    }
    public function ver(){
        return view('books.show');
    }
    
}

