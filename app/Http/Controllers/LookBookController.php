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
    if ($request->has('collections')) {
        $collectionIds = $request->collections;

        if (is_array($collectionIds) && count(array_filter($collectionIds)) > 0) {
            $query->whereHas('collections', function ($q) use ($collectionIds) {
                $q->whereIn('collections.id', array_filter($collectionIds));
            });
        } else {
            $query->whereHas('collections');
        }
    }


    // Filtro por categorías (funciona incluso si no hay colecciones seleccionadas)
    if ($request->has('categories')) {
        $categoryIds = $request->categories;

        if (is_array($categoryIds) && count(array_filter($categoryIds)) > 0) {
            // Categorías seleccionadas (excluyendo valores vacíos)
            $query->whereHas('categories', function ($q) use ($categoryIds) {
                $q->whereIn('categories.id', array_filter($categoryIds));
            });
        } else {
            // Solo se seleccionó "todas las categorías" (sin categorías específicas)
            $query->whereHas('categories');
        }
    }


    $books = $query->get();
    $collections = Collection::all();
    $categories = Category::all();

    session()->flash('filters_applied', true);


    return view('books', compact('books', 'collections', 'categories'));
    } 

}
