<?php

require_once './app/controllers/AuthController.php';
require_once './app/controllers/HomeController.php';

use Core\Route;
use App\Controllers\AuthController;
use App\Controllers\HomeController;

Route::register("get", "/", [ HomeController::class, 'index' ], ['Test'] );

Route::register("get", "/login", [ AuthController::class, 'access' ] );
Route::register("post", "/login", [ AuthController::class, 'login' ] );







