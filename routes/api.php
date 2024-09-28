<?php

use App\Http\Controllers\bookController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\ProgressController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\ShelvesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
Route::post('/v1/users', [UserController::class, 'store']);
Route::get('/v1/books',[bookController::class, 'book'])->name('show.book'); // ?filter=category&value=5
Route::get('/v1/categories/',[CategoryController::class, 'category'])->name('show.category');
Route::get('/v1/collections/',[CollectionController::class, 'collection'])->name('show.collection');     
Route::post('/v1/progress/',[ProgressController::class, 'store'])->name('');
Route::patch('/v1/progress/{id}',[ProgressController::class, 'update'])->name('');
Route::post('/v1/shelves/',[ShelvesController::class, 'store'])->name('');

Route::post('/v1/ratings/{id}',[RatingController::class, 'store'])->name('');
Route::get('/v1/ratings/{id}',[RatingController::class, 'update'])->name('');
Route::get('/api/v1/books/{id}',[bookController::class, ''])->name('');

