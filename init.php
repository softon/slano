<?php


use App\Database\User;
use Delight\Auth\Auth;
use Dotenv\Dotenv;
use Models\DB;
use Models\Model;

global $router, $db, $auth;

if(empty($_SESSION)){
    session_start();
}

/* Router */
$router = new \Bramus\Router\Router();

/* Load Environment Vars */
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();


/* Database connection and Models Loading */
$db = new DB($_ENV['DB_HOST'], $_ENV['DB_NAME'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);
Model::setDb($db);

/* Authentication */
$auth = new Auth($db);


/* Init Models */
User::register('users');


