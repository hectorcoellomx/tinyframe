<?php

use App\Http\Controllers\LibraryController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::get('/',function(){
    return view('layouts.home');
});

Route::get('/books',function(){
    return view('layouts.books');
});

