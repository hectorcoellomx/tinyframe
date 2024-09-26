<?php

namespace App\Http\Controllers;

use App\Models\book;
use Illuminate\Http\Request;

class bookController extends Controller
{
    public function book(Request $request){
        $filter = $request->query('filter');
        $value = $request->query('value');
        
        $books = Book::query();

        if ($filter && $value) {
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
                        $query->where('user_id', $value);  //filtrar por el ID del usuario que añadió el libro a su estantería
                    });
                    break;

                case 'most_read':
                    $books->withCount('ratings')
                        ->orderBy('ratings_count', 'desc');
                    break;

                case 'keyword':
                    $books->where('keywords', 'LIKE', '%' . $value . '%');
                    break;
            }
            
        }
        $books = $books->get();

        return response()->json($books);

    }
    
}
