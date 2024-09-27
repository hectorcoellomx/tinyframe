<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Progress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
                        $result = DB::table('books')
                        ->join('progress', 'progress.book_id', '=', 'books.id')
                        ->select('books.*', DB::raw('COUNT(progress.id) as total'))
                        ->groupBy('books.id')
                        ->orderBy('total', 'desc')
                        ->get();
                        break;
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
                    'message' => "Parámetros inválidos",
                    'error' => [
                        'code' => 401,
                        'details' => "Invalid params",
                    ]
                ], 401);

            }

        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "data" => null,
                'message' => "Ha ocurrido un error inesperado",
                'error' => [
                    'code' => $e->getCode(),
                    'details' => $e->getMessage(),
                ]
            ], 500);
        }
       
    }
    
}
