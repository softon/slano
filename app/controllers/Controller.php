<?php

namespace App\Controllers;

use App\Providers\TwigExtension;
use Rakit\Validation\Validator;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\TwigFunction;

class Controller {
    public $twig;
    public $validator;
    public $db;
    
    function __construct() {
        global $db;
        $loader = new FilesystemLoader(__DIR__ . '/../../views');
        $this->twig = new Environment($loader, [
            //'cache' => __DIR__ . '/../cache',
        ]);

        $this->twig->addExtension(new TwigExtension());

        $this->validator = new Validator;
        $this->db = $db;
    }

}