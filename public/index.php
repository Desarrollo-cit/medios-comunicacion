<?php 
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
require_once __DIR__ . '/../includes/app.php';


use Controllers\EventoController;
use MVC\Router;
use Controllers\AppController;
$router = new Router();
$router->setBaseURL('/medios-comunicacion');

$router->get('/', [AppController::class,'index']);
$router->get('/eventos', [EventoController::class,'index']);
$router->get('/API/eventos', [EventoController::class,'eventos']);
$router->get('/API/eventos/municipios', [EventoController::class, 'municipios']);
$router->post('/API/eventos/guardar', [EventoController::class, 'guardar']);

// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();
