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

Route::get('/v1/books',[bookController::class, 'book']);
Route::get('/v1/categories/',[CategoryController::class, 'category']);
Route::get('/v1/collections/',[CollectionController::class, 'collection']);
Route::post('/v1/progress/',[ProgressController::class, 'store']);
Route::patch('/v1/progress/{id}',[ProgressController::class, 'update']);
Route::post('/v1/shelves/',[ShelvesController::class, 'store']);
Route::post('/v1/ratings/{id}',[RatingController::class, 'store']);
Route::get('/v1/ratings/{id}',[RatingController::class, 'show']);
Route::get('/v1/books/{id}/{user_id}',[bookController::class, 'show']);


// Route::group([
//     'middleware' => 'api',
//     'prefix' => 'auth'
// ], function($router){
//     Route::post('/v1/users', [UserController::class, 'store']);
//     Route::post('/v1/users/login', [UserController::class, 'login']);
//     Route::post('/v1/users/refresh', [UserController::class, 'refresh']);
//     Route::post('/v1/users/me', [UserController::class, 'me']);
// });
