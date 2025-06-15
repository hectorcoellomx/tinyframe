<?php

route_get('/', 'HomeController::index', ['Test']);
route_get('/login', 'AuthController::access');
route_post('/login', 'AuthController::login');



