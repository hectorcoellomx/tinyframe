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


Route::post('/users', [UserController::class, 'store']);
Route::get('/books',[bookController::class, 'book']);
Route::get('/categories/',[CategoryController::class, 'category']);
Route::get('/collections/',[CollectionController::class, 'collection']);
Route::post('/progress/',[ProgressController::class, 'store']);
Route::patch('/progress/{id}',[ProgressController::class, 'update']);
Route::post('/shelves/',[ShelvesController::class, 'store']);
Route::post('/ratings/{id}',[RatingController::class, 'store']);
Route::get('/ratings/{id}',[RatingController::class, 'show']);
Route::get('/books/{id}/{user_id}',[bookController::class, 'show']);


// Route::group([
//     'middleware' => 'api',
//     'prefix' => 'auth'
// ], function($router){
//     Route::post('/users', [UserController::class, 'store']);
//     Route::post('/users/login', [UserController::class, 'login']);
//     Route::post('/users/refresh', [UserController::class, 'refresh']);
//     Route::post('/users/me', [UserController::class, 'me']);
// });
