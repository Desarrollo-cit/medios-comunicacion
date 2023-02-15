<?php

namespace Controllers;

use MVC\Router;

class AppController {
    public static function index(Router $router){
        isAuth();
        hasPermission(['AMC_ADMIN']);
        $router->render('pages/index', []);
    }

}