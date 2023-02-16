<?php

namespace Controllers;

use MVC\Router;

class AppController {
    public static function index(Router $router){
        isAuth();
        hasPermission(['AMC_ADMIN', 'AMC_COMANDO']);
        $router->render('pages/index', []);
    }

}