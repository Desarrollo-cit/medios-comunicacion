<?php 
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
require_once __DIR__ . '/../includes/app.php';


use MVC\Router;
use Controllers\AppController;
use Controllers\ColoresController;
$router = new Router();
$router->setBaseURL('/medios-comunicacion');

$router->get('/', [AppController::class,'index']);
$router->get('/colores',[ColoresController::class,'index']);
$router->post('/API/colores/guardar', [ColoresController::class, 'guardarAPI'] );
$router->get('/API/colores/buscar', [ColoresController::class, 'buscarAPI'] );
$router->post('/API/colores/modificar', [ColoresController::class, 'modificarAPI'] );
$router->post('/API/colores/eliminar', [ColoresController::class, 'eliminarAPI'] );


// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();
