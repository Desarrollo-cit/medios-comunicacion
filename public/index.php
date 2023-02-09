<?php 
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
require_once __DIR__ . '/../includes/app.php';


use MVC\Router;
use Controllers\AppController;
use Controllers\infoCapturaController;
use Controllers\infoMuertesController;
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



$router->get('/mapas/muertes', [infoMuertesController::class , 'index']);
$router->post('/API/mapas/IndexMuertes/resumen', [infoMuertesController::class , 'resumenAPI'] );
$router->get('/API/mapas/IndexMuertes/listado', [infoMuertesController::class , 'listadoAPI'] );
$router->post('/API/mapas/IndexMuertes/modal', [infoMuertesController::class , 'modalAPI'] );
$router->post('/API/mapas/IndexMuertes/informacion', [infoMuertesController::class , 'informacionModalAPI'] );
$router->post('/API/mapas/IndexMuertes/informacion1', [infoMuertesController::class , 'informacionModalAPI1'] );
$router->post('/API/mapas/IndexMuertes/mapaCalor', [infoMuertesController::class , 'mapaCalorAPI'] );
$router->post('/API/mapas/IndexMuertes/mapaCalorPorDepto', [infoMuertesController::class , 'mapaCalorDeptoAPI'] );
$router->post('/API/mapas/IndexMuertes/colores', [infoMuertesController::class , 'coloresAPI'] );







// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();
