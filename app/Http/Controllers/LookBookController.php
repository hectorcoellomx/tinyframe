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
        
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->has('collections')) {
            $collectionIds = $request->collections;

            if (is_array($collectionIds) && count(array_filter($collectionIds)) > 0) {
                $query->whereHas('collections', function ($q) use ($collectionIds) {
                    $q->whereIn('collections.id', array_filter($collectionIds));
                });
            }
        }

        if ($request->has('categories')) {
            $categoryIds = $request->categories;

            if (is_array($categoryIds) && count(array_filter($categoryIds)) > 0) {
                $query->whereHas('categories', function ($q) use ($categoryIds) {
                    $q->whereIn('categories.id', array_filter($categoryIds));
                });
            }
        }

        $books = $query->get();
        $collections = Collection::all();
        $categories = Category::all();

        session()->flash('filters_applied', true);

        return view('books', compact('books', 'collections', 'categories'));
        
    } 

}
