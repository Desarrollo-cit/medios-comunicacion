<?php

namespace Controllers;

use MVC\Router;

class EventoController {
    public static function index(Router $router){
        $router->render('eventos/index', []);
    }

}