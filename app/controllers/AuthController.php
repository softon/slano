<?php

namespace App\Controllers;

use App\Database\User;

class AuthController extends Controller {


    
    public function index(){
        $users = User::select("SELECT * FROM users");
        
        echo $this->twig->render('index.twig', compact(['users']));
    }
    

    public function loginForm(){
        global $auth;
        /* $userId = $auth->register('deepu.freelancer@gmail.com', 'Kulfi$123', 'admin', function ($selector, $token) {
            echo 'Send ' . $selector . ' and ' . $token . ' to the user (e.g. via email)';
        });
        $userId = $auth->register('nileshkapoorkulfi.com@gmail.com', 'Nilesh123', 'nilesh', function ($selector, $token) {
            echo 'Send ' . $selector . ' and ' . $token . ' to the user (e.g. via email)';
        }); */
        if ($auth->isLoggedIn()) {
            header('location: /');
            exit();
        }
        echo $this->twig->render('login.twig');
    }

    public function login(){
        global $auth;
        $validation = $this->validator->make($_POST + $_FILES, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $validation->validate();
        if ($validation->fails()) {
            // handling errors
            $errors = $validation->errors();
            $_SESSION['message']['type'] = 'alert-danger';
            $_SESSION['message']['text'] = $errors->firstOfAll();
            header('Location: /login');
            exit();
        }

        try {
            $auth->login($_POST['email'], $_POST['password']);
        
            header('Location: /');
            exit();
        }
        catch (\Delight\Auth\InvalidEmailException $e) {
            $_SESSION['message']['text'] = 'Wrong email address';
        }
        catch (\Delight\Auth\InvalidPasswordException $e) {
            $_SESSION['message']['text'] = 'Wrong password';
        }
        catch (\Delight\Auth\EmailNotVerifiedException $e) {
            $_SESSION['message']['text'] = 'Email not verified';
        }
        catch (\Delight\Auth\TooManyRequestsException $e) {
            $_SESSION['message']['text'] = 'Too many requests';
        }

        $_SESSION['message']['type'] = 'alert-danger';
        header('Location: /login');
        exit();

    }


    public function registerForm(){
        global $auth;
        
        if ($auth->isLoggedIn()) {
            header('location: /');
            exit();
        }
        echo $this->twig->render('register.twig');
    }

    public function register(){
        global $auth;
        $validation = $this->validator->make($_POST + $_FILES, [
            'email' => 'required|email',
            'username' => 'required',
            'password' => 'required',
        ]);

        $validation->validate();
        if ($validation->fails()) {
            // handling errors
            $errors = $validation->errors();
            $_SESSION['message']['type'] = 'alert-danger';
            $_SESSION['message']['text'] = $errors->firstOfAll();
            header('Location: /register');
            exit();
        }

        try {
            $userId = $auth->register($_POST['email'], $_POST['password'], $_POST['username']);
        
            $_SESSION['message']['type'] = 'alert-success';
            $_SESSION['message']['text'] = 'New account created successfully.';
            header('Location: /login');
            exit();
        }
        catch (\Delight\Auth\InvalidEmailException $e) {
            $_SESSION['message']['text'] = 'Invalid email address';
        }
        catch (\Delight\Auth\InvalidPasswordException $e) {
            $_SESSION['message']['text'] = 'Invalid password';
        }
        catch (\Delight\Auth\UserAlreadyExistsException $e) {
            $_SESSION['message']['text'] = 'User already exists';
        }
        catch (\Delight\Auth\TooManyRequestsException $e) {
            $_SESSION['message']['text'] = 'Too many requests';
        }

        $_SESSION['message']['type'] = 'alert-danger';
        header('Location: /register');
        exit();

    }

    public function logout(){
        global $auth;
        $auth->logOut();
        header('location: /login');
        exit();
    }
}