<?php

use App\Http\Controllers\bookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::get('/',function(){
    return view('layouts.app');
});

Route::get('/books',function(){
    return view('layouts.books');
});

Route::get('/users/show',[UserController::class, 'show']);

Route::put('/books/create',[bookController::class, 'create']);
Route::get('/books/show',[bookController::class, 'ver']);

Route::get('/categories/show',[CategoryController::class, 'show']);

