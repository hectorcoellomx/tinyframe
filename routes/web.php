<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\bookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\LookBookController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;


Route::get('/',[ LookBookController::class, 'index' ])->name('books');

Route::get('/lector-example',function(){
    return view('epub.example');
});

Route::get('/login', [AuthController::class, 'login']);
Route::post('/login', [AuthController::class, 'authenticate'])->name('auth.authenticate');
Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');


// Ruta protegida para la vista de usuarios
Route::middleware('auth.custom')->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('users/create',[UserController::class, 'create'])->name('users.create');

    Route::get('/books/create',[BookController::class, 'create'])->name('books.create');
    Route::get('/books',[BookController::class, 'index'])->name('books.index');
    Route::get('/books/{book}',[BookController::class, 'ver'])->name('books.ver');
    Route::post('/books',[BookController::class, 'store'])->name('books.store');
    Route::get('/books/{book}/edit',[BookController::class, 'edit'])->name('books.edit');
    Route::put('/books/{book}',[BookController::class,'update'])->name('books.update');
    Route::delete('/books/{book}', [BookController::class, 'destroy'])->name('books.destroy'); 
    Route::resource('authors' ,AuthorController::class);
    Route::resource('collections', CollectionController::class);
    Route::resource('categories', CategoryController::class);
});

// Route::get('/books-public',function(){
//     return view('books');
// });

Route::get('/lector-epub/{archivo}', function ($archivo) {
    $safeFile = basename($archivo); 
    
    $path = 'files/' . $safeFile;
    
    if (!Storage::disk('public')->exists($path)) {
        abort(404, 'El archivo no existe');
    }
    
    // Verificar extensión .epub
    if (!preg_match('/\.epub$/i', $safeFile)) {
        abort(400, 'El archivo debe tener extensión .epub');
    }
    
    return view('epub.lector-epub', [
        'archivo' => $safeFile
    ]);
});


