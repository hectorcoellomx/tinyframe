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



Route::get('/lector-example',function(){
    return view('epub.example');
});
// Mostrar el formulario de login

Route::get('/login', [AuthController::class, 'login']);
// Manejar el inicio de sesión
Route::post('/login', [AuthController::class, 'authenticate'])->name('auth.authenticate');

// Cerrar sesión
Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');

// Ruta protegida para la vista de usuarios
Route::middleware('auth.custom')->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('users/create',[UserController::class, 'create'])->name('users.create');

    Route::get('/books/create',[bookController::class, 'create'])->name('books.create');
    Route::get('/books',[bookController::class, 'index'])->name('books.index');
    Route::get('/books/{book}',[bookController::class, 'ver'])->name('books.ver');
    Route::post('/books',[bookController::class, 'store'])->name('books.store');
    Route::get('/books/{book}/edit',[bookController::class, 'edit'])->name('books.edit');
    Route::put('/books/{book}',[bookController::class,'update'])->name('books.update');
    Route::delete('/books/{book}', [bookController::class, 'destroy'])->name('books.destroy'); 

    //Rutas Autores
    Route::resource('authors' ,AuthorController::class);
    
    //Rutas Colecciones
    Route::resource('collections', CollectionController::class);
    
    //Rutas Categorías 
    Route::resource('categories', CategoryController::class);
});

// Route::get('/books-public',function(){
//     return view('books');
// });
Route::get('/',[LookBookController::class, 'index'])->name('books');


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


