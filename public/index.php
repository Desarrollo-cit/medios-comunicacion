<?php 
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
require_once __DIR__ . '/../includes/app.php';


use MVC\Router;
use Controllers\AppController;
use Controllers\infoCapturaController;
$router = new Router();
$router->setBaseURL('/medios-comunicacion');

$router->get('/', [AppController::class,'index']);

$router->get('/mapas/capturas', [infoCapturaController::class , 'index']);
$router->post('/API/mapas/infoCapturas/resumen', [infoCapturaController::class , 'resumenAPI'] );
$router->get('/API/mapas/infoCapturas/listado', [infoCapturaController::class , 'listadoAPI'] );
$router->post('/API/mapas/infoCapturas/modal', [infoCapturaController::class , 'modalAPI'] );
$router->post('/API/mapas/infoCapturas/informacion', [infoCapturaController::class , 'informacionModalAPI'] );
$router->post('/API/mapas/infoCapturas/informacion1', [infoCapturaController::class , 'informacionModalAPI1'] );
$router->post('/API/mapas/infoCapturas/mapaCalor', [infoCapturaController::class , 'mapaCalorAPI'] );
$router->post('/API/mapas/infoCapturas/mapaCalorPorDepto', [infoCapturaController::class , 'mapaCalorDeptoAPI'] );
$router->post('/API/mapas/infoCapturas/colores', [infoCapturaController::class , 'coloresAPI'] );
// $router->get('/API/productos/buscar', [ProductoController::class, 'buscarAPI'] );
// $router->post('/API/productos/modificar', [ProductoController::class, 'modificarAPI'] );
// $router->post('/API/productos/eliminar', [ProductoController::class, 'eliminarAPI'] );


// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();
