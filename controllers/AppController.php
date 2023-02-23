<?php

namespace Controllers;

use MVC\Router;

class AppController {
    public static function index(Router $router){
        isAuth();
        hasPermission(['AMC_ADMIN', 'AMC_COMANDO']);
        $router->render('pages/index', []);
    }

    public static function cerrarSesion(){
        session_start();
        $_SESSION = [];
        session_destroy();
        header('location: /');
        exit;
    }

}