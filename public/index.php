<?php

use Database\User;

require __DIR__.'/../vendor/autoload.php';


include(__DIR__.'/../routes.php');





function doAuth(){
    global $auth;
    if (!$auth->isLoggedIn()) {
        header('location: /login');
        exit();
    }
}

$router->run(function() {
    
});