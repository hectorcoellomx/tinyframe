<?php

require_once './app/controllers/HomeController.php';
require_once './app/controllers/StudentApiController.php';

use Core\Route;
use App\Controllers\HomeController;

Route::register("get", "/", [ HomeController::class, 'index' ], [ 'test' ] );
Route::register("get", "/api/student", [ HomeController::class, 'index' ] );

Route::register("get", "/login", [ HomeController::class, 'access' ] );
Route::register("post", "/login", [ HomeController::class, 'login' ] );
Route::register("get", "/dashboard", [ HomeController::class, 'dashboard' ], [ 'test' ] ); 

Route::register("get", "/profile/{id}", [ HomeController::class, 'dashboard' ], [ 'test' ] ); 






