<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\bookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\UserController;
use App\Models\Author;
use App\Models\Category;
use Illuminate\Support\Facades\Route;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;


// Route::get('/',function(){
//     return view('users.index');
// });
//Route::get('/',[UserController::class,'index']);

//Route::get('/login',[AuthController::class, 'login']);

Route::get('/books',function(){
    return view('layouts.books');
});

Route::get('/lector-example',function(){
    return view('epub.example');
});
// Mostrar el formulario de login
Route::get('/', [AuthController::class, 'login'])->name('auth.login');

// Manejar el inicio de sesión
Route::post('/login', [AuthController::class, 'authenticate'])->name('auth.authenticate');

// Cerrar sesión
Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');

// Ruta protegida para la vista de usuarios
Route::middleware('auth.custom')->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
});



Route::get('/lector-epub/{archivo}', function ($archivo) {
    $safeFile = basename($archivo); // Previene directory traversal
    
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
// ->where('archivo', '[a-zA-Z0-9\-_]+\.epub');



Route::get('/users',[UserController::class, 'index']);
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
Route::get('/authors',[AuthorController::class, 'index']);
Route::get('/authors/{author}',[AuthorController::class, 'show']);
Route::post('/authors',[AuthorController::class, 'store']);
Route::get('/authors/{author}/edit',[AuthorController::class, 'edit']);
Route::put('/authors/{author}',[AuthorController::class,'update']);
Route::delete('/authors/{author}', [AuthorController::class, 'destroy']);

Route::get('/collections/create',[CollectionController::class, 'create']);
Route::get('/collections',[CollectionController::class, 'index']);
Route::get('/collections/{collection}',[CollectionController::class, 'show']);
Route::post('/collections/{collection}',[CollectionController::class, 'store']);
Route::get('/collections/{collection}/edit',[CollectionController::class, 'edit']);
Route::put('/collections/{collection}',[CollectionController::class,'update']);
Route::delete('/collections/{collection}', [CollectionController::class, 'destroy']);
