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
use Controllers\Desastre_naturalController;
use Controllers\Fenomeno_naturalController;
use Controllers\MonedaController;

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

//DESASTRES NATURALES
$router->get('/desastre_natural', [Desastre_naturalController::class , 'index']);
$router->post('/API/desastre_natural/guardar', [Desastre_naturalController::class, 'guardarAPI'] );
$router->get('/API/desastre_natural/buscar', [Desastre_naturalController::class, 'buscarAPI'] );
$router->post('/API/desastre_natural/modificar', [Desastre_naturalController::class, 'modificarAPI'] );
$router->post('/API/desastre_natural/eliminar', [Desastre_naturalController::class, 'eliminarAPI'] );
 
//FENOMENOS NATURALES
$router->get('/fenomeno_natural', [Fenomeno_naturalController::class , 'index']);
$router->post('/API/fenomeno_natural/guardar', [Fenomeno_naturalController::class, 'guardarAPI'] );
$router->get('/API/fenomeno_natural/buscar', [Fenomeno_naturalController::class, 'buscarAPI'] );
$router->post('/API/fenomeno_natural/modificar', [Fenomeno_naturalController::class, 'modificarAPI'] );
$router->post('/API/fenomeno_natural/eliminar', [Fenomeno_naturalController::class, 'eliminarAPI'] );


 
//MONEDA
$router->get('/moneda', [MonedaController::class , 'index']);
$router->post('/API/moneda/guardar', [MonedaController::class, 'guardarAPI'] );
$router->get('/API/moneda/buscar', [MonedaController::class, 'buscarAPI'] );
$router->post('/API/moneda/modificar', [MonedaController::class, 'modificarAPI'] );
$router->post('/API/moneda/eliminar', [MonedaController::class, 'eliminarAPI'] );



// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();
