<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\bookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\UserController;
use App\Models\Category;
use Illuminate\Support\Facades\Route;
use Illuminate\Contracts\View\View;


Route::get('/',function(){
    return view('layouts.app');
});

Route::get('/login',[AuthController::class, 'login']);

Route::get('/books',function(){
    return view('layouts.books');
});

Route::get('/users/index',[UserController::class, 'index']);
Route::get('users/create',[UserController::class, 'create']);

Route::get('/books/create',[bookController::class, 'create']);
Route::get('/books',[bookController::class, 'index']);
Route::get('/books/{book}',[bookController::class, 'ver']);
Route::post('/books',[bookController::class, 'store']);
Route::get('/books/{book}/edit',[bookController::class, 'edit']);
Route::put('/books/{book}',[bookController::class,'update']);
Route::delete('/books/{book}', [bookController::class, 'destroy']);

Route::get('/categories/create',[CategoryController::class, 'create']);
Route::get('/categories',[CategoryController::class, 'index']);
Route::get('/categories/{category}',[CategoryController::class, 'show']);
Route::post('/categories',[CategoryController::class, 'store']);
Route::delete('/categories/{category}', [CategoryController::class, 'destroy']);

Route::get('/authors/create',[AuthorController::class, 'create']);
Route::get('/authors/index',[AuthorController::class, 'index']);
Route::get('/authors/show',[AuthorController::class, 'show']);

Route::get('/collections/create',[CollectionController::class, 'create']);
Route::get('/collections',[CollectionController::class, 'index']);
Route::get('/collections/{collection}',[CollectionController::class, 'show']);
Route::post('collections/{collection}',[CollectionController::class, 'store']);

