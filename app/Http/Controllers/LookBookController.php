<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Models\Collection;
use Illuminate\Http\Request;

class LookBookController extends Controller
{
    public function index(Request $request){
        
    $query = Book::query();

    // Filtro por título
    if ($request->filled('search')) {
        $query->where('title', 'like', '%' . $request->search . '%');
    }

    // Filtro por colecciones (funciona incluso si no hay categorías seleccionadas)
    if ($request->has('collections') && is_array($request->collections)) {
        $query->whereHas('collections', function ($q) use ($request) {
            $q->whereIn('collections.id', $request->collections);
        });
    }

    // Filtro por categorías (funciona incluso si no hay colecciones seleccionadas)
    if ($request->has('categories') && is_array($request->categories)) {
        $query->whereHas('categories', function ($q) use ($request) {
            $q->whereIn('categories.id', $request->categories);
        });
    }

    $books = $query->get();
    $collections = Collection::all();
    $categories = Category::all();

    return view('books', compact('books', 'collections', 'categories'));
    } 

}
