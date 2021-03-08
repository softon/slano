<?php 

/* Your Routes */


$router->get('/login', 'App\Controllers\AuthController@loginForm');
$router->post('/login', 'App\Controllers\AuthController@login');
$router->get('/logout', 'App\Controllers\AuthController@logout');


// Middleware
$router->before('GET|POST', '/', function() {
    doAuth();
});

$router->get('/', 'App\Controllers\AuthController@index');
