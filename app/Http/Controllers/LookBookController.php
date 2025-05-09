<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Models\Collection;
use Illuminate\Http\Request;

class LookBookController extends Controller
{
    public function index(){
        $books = Book::all();
        $collections = Collection::all();
        $categories = Category::all();
        return view('books',compact('books', 'collections', 'categories'));
    }
}
