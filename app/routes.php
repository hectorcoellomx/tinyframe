<?php

route_get('/', 'HomeController::index', ['Test']);

route_group(['Test'], function () {
    route_get('/login', 'AuthController::access');
    route_post('/login', 'AuthController::login');
});


route_api_get('/api/user', 'UserApiController::list');
route_api_post('/api/user', 'UserApiController::create');


