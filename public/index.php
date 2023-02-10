<?php 
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
require_once __DIR__ . '/../includes/app.php';


use Controllers\ArmasController;
use Controllers\CalibresController;
use Controllers\CapturaController;
use Controllers\DelitosController;


use Controllers\EventoController;
use Controllers\IncautacionController;
use MVC\Router;
use Controllers\AppController;

use Controllers\OrganizacionController;
use Controllers\TipoController;
use Controllers\NacionalidadController;
use Controllers\ColoresController;
use Controllers\Desastre_naturalController;
use Controllers\Fenomeno_naturalController;
use Controllers\MonedaController;
use Controllers\AsesinatosController;



use Controllers\infoCapturaController;
use Controllers\infoDrogaController;

$router = new Router();
$router->setBaseURL('/medios-comunicacion');

$router->get('/', [AppController::class,'index']);


$router->get('/colores',[ColoresController::class,'index']);
$router->post('/API/colores/guardar', [ColoresController::class, 'guardarAPI'] );
$router->get('/API/colores/buscar', [ColoresController::class, 'buscarAPI'] );
$router->post('/API/colores/modificar', [ColoresController::class, 'modificarAPI'] );
$router->post('/API/colores/eliminar', [ColoresController::class, 'eliminarAPI'] );




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



$router->get('/organizacion', [OrganizacionController::class , 'index']);
$router->post('/API/organizacion/guardar', [OrganizacionController::class, 'guardarAPI'] );
$router->get('/API/organizacion/buscar', [OrganizacionController::class, 'buscarAPI'] );
$router->post('/API/organizacion/modificar', [OrganizacionController::class, 'modificarAPI'] );
$router->post('/API/organizacion/eliminar', [OrganizacionController::class, 'eliminarAPI'] );

$router->get('/tipo', [TipoController::class , 'index']);
$router->post('/API/tipo/guardar', [TipoController::class, 'guardarAPI'] );
$router->get('/API/tipo/buscar', [TipoController::class, 'buscarAPI'] );
$router->post('/API/tipo/modificar', [TipoController::class, 'modificarAPI'] );
$router->post('/API/tipo/eliminar', [TipoController::class, 'eliminarAPI'] );

$router->get('/nacionalidad', [NacionalidadController::class , 'index']);
$router->post('/API/nacionalidad/guardar', [NacionalidadController::class, 'guardarAPI'] );
$router->get('/API/nacionalidad/buscar', [NacionalidadController::class, 'buscarAPI'] );
$router->post('/API/nacionalidad/modificar', [NacionalidadController::class, 'modificarAPI'] );
$router->post('/API/nacionalidad/eliminar', [NacionalidadController::class, 'eliminarAPI'] );


$router->get('/eventos', [EventoController::class,'index']);
$router->get('/API/eventos', [EventoController::class,'eventos']);
$router->get('/API/eventos/municipios', [EventoController::class, 'municipios']);
$router->post('/API/eventos/guardar', [EventoController::class, 'guardar']);
$router->get('/API/eventos/sexo', [EventoController::class, 'sexos']);

$router->post('/API/capturas/guardar', [CapturaController::class, 'guardar']);
$router->post('/API/capturas/modificar', [CapturaController::class, 'modificar']);
$router->get('/API/capturas/buscar', [CapturaController::class, 'buscarCapturaAPI']);
$router->post('/API/capturas/capturado/eliminar', [CapturaController::class, 'eliminarCapturado']);
$router->post('/API/capturas/eliminar', [CapturaController::class, 'eliminarCaptura']);

$router->post('/API/asesinatos/guardar', [AsesinatosController::class, 'guardar']);
$router->post('/API/asesinatos/modificar', [AsesinatosController::class, 'modificar']);
$router->get('/API/asesinatos/buscar', [AsesinatosController::class, 'buscarAsesinatosAPI']);
$router->post('/API/asesinatos/asesinado/eliminar', [AsesinatosController::class, 'eliminarAsesinado']);
$router->post('/API/asesinatos/eliminar', [AsesinatosController::class, 'eliminarAsesinato']);



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

$router->post('/API/incautacion/guardar', [IncautacionController::class, 'guardar']);
$router->get('/API/incautacion/buscar', [IncautacionController::class, 'buscarIncautacionAPI']);

$router->get('/mapas/droga', [infoDrogaController::class , 'index']);


// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();
