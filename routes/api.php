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
Route::get('/categories',[CategoryController::class, 'category']);
Route::get('/collections',[CollectionController::class, 'collection']);

Route::post('/progress',[ProgressController::class, 'store']);
Route::post('/shelves',[ShelvesController::class, 'store']);
Route::post('/ratings/{id}',[RatingController::class, 'store']);
Route::get('/books/{id}/{user_id}',[bookController::class, 'show']);
