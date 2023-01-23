<?php 
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
require_once __DIR__ . '/../includes/app.php';

use Controllers\ArmasController;
use Controllers\CalibresController;
use Controllers\DelitosController;
use MVC\Router;
use Controllers\AppController;
$router = new Router();
$router->setBaseURL('/medios-comunicacion');

$router->get('/', [AppController::class,'index']);


$router->get('/armas', [ArmasController::class , 'index']);
$router->post('/API/armas/guardar', [ArmasController::class, 'guardarAPI'] );
$router->get('/API/armas/buscar', [ArmasController::class, 'buscarAPI'] );
$router->post('/API/armas/modificar', [ArmasController::class, 'modificarAPI'] );
$router->post('/API/armas/eliminar', [ArmasController::class, 'eliminarAPI'] );


$router->get('/calibres', [CalibresController::class , 'index']);
$router->post('/API/calibres/guardar', [CalibresController::class, 'guardarAPI'] );
$router->get('/API/calibres/buscar', [CalibresController::class, 'buscarAPI'] );
$router->post('/API/calibres/modificar', [CalibresController::class, 'modificarAPI'] );
$router->post('/API/calibres/eliminar', [CalibresController::class, 'eliminarAPI'] );


$router->get('/delitos', [DelitosController::class , 'index']);
$router->post('/API/delitos/guardar', [DelitosController::class, 'guardarAPI'] );
$router->get('/API/delitos/buscar', [DelitosController::class, 'buscarAPI'] );
$router->post('/API/delitos/modificar', [DelitosController::class, 'modificarAPI'] );
$router->post('/API/delitos/eliminar', [DelitosController::class, 'eliminarAPI'] );


// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();
