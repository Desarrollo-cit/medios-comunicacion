<?php

namespace Controllers;

use MVC\Router;

class EventoController {
    public static function index(Router $router){
        // $topicos = 
        $router->render('eventos/index', []);
    }

}