<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
Route::post('/users', [UserController::class, 'store']);

// Route::post('/api/v1/users',[LibraryController::class, 'store'])->name('user.store');
// Route::get('/api/v1/books',[LibraryController::class, 'book'])->name('show.book'); // ?filter=category&value=5
// Route::get('/api/v1/categories/',[LibraryController::class, ''])->name('');
// Route::get('/api/v1/collections/',[LibraryController::class, ''])->name('');
// Route::post('/api/v1/progress/',[LibraryController::class, ''])->name('');
// Route::post('/api/v1/shelves/',[LibraryController::class, ''])->name('');
// Route::post('/api/v1/ratings/',[LibraryController::class, ''])->name('');
// Route::get('/api/v1/ratings/{id}',[LibraryController::class, ''])->name('');
// Route::get('/api/v1/books/{id}',[LibraryController::class, ''])->name('');

