<?php

use App\Http\Controllers\bookController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
Route::post('/v1/users', [UserController::class, 'store']);
Route::get('/v1/books',[bookController::class, 'book'])->name('show.book'); // ?filter=category&value=5
// Route::get('/api/v1/categories/',[LibraryController::class, ''])->name('');
// Route::get('/api/v1/collections/',[LibraryController::class, ''])->name('');
// Route::post('/api/v1/progress/',[LibraryController::class, ''])->name('');
// Route::post('/api/v1/shelves/',[LibraryController::class, ''])->name('');
// Route::post('/api/v1/ratings/',[LibraryController::class, ''])->name('');
// Route::get('/api/v1/ratings/{id}',[LibraryController::class, ''])->name('');
// Route::get('/api/v1/books/{id}',[LibraryController::class, ''])->name('');

