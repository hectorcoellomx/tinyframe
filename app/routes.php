<?php

use Core\Route;


Route::register("get", "/", [ 'HomeController', 'index' ], ['Test'] );
Route::register("get", "/login", ['AuthController', 'access' ] );
Route::register("post", "/login", [ 'AuthController', 'login' ] );






