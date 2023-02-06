<?php 
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
require_once __DIR__ . '/../includes/app.php';


use MVC\Router;
use Controllers\AppController;
use Controllers\infoCapturaController;
use Controllers\infoDrogaController;
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
$router->post('/API/mapas/infoCapturas/mapaCalorPorDeptoGrafica', [infoCapturaController::class , 'mapaCalorPorDeptoGraficaAPI'] );
$router->post('/API/mapas/infoCapturas/colores', [infoCapturaController::class , 'coloresAPI'] );
$router->post('/API/mapas/infoCapturas/DelitosCantGrafica', [infoCapturaController::class , 'DelitosCantGraficaAPI'] );
$router->post('/API/mapas/infoCapturas/DelitosDepartamentoGrafica', [infoCapturaController::class , 'DelitosDepartamentoGraficaAPI'] );
$router->post('/API/mapas/infoCapturas/CapturasPorDiaGrafica', [infoCapturaController::class , 'CapturasPorDiaGraficaAPI'] );
$router->post('/API/mapas/infoCapturas/GraficaTrimestral', [infoCapturaController::class , 'GraficaTrimestralAPI'] );
$router->post('/API/mapas/infoCapturas/GraficaTrimestralGeneral', [infoCapturaController::class , 'GraficaTrimestralGeneralAPI'] );



$router->get('/mapas/droga', [infoDrogaController::class , 'index']);

// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();
