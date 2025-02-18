<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function create(){
        return view('authors.create');
    }

    public function index(){
        return view('authors.index');
    }

    public function show(){
        return view('authors.show');
    }
}
