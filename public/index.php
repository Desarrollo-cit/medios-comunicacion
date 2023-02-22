<?php 
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
require_once __DIR__ . '/../includes/app.php';
date_default_timezone_set('America/Guatemala');
setlocale(LC_ALL, 'es_ES');

use Controllers\FuentesController;
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
use Controllers\Des_naturalController;
use Controllers\DineroController;
use Controllers\MigrantesController;
use Controllers\DesastresController;

use Controllers\ReporteController;


use Controllers\infoCapturaController;
use Controllers\infoMuertesController;
use Controllers\infoDrogaController;
use Controllers\Mov_socialController;
use Controllers\PistasController;
use Controllers\infoMarasController;
use Controllers\infoMigrantesController;



$router = new Router();
$router->setBaseURL('/medios-comunicacion');

$router->get('/', [AppController::class,'index']);


$router->get('/colores',[ColoresController::class,'index']);
$router->post('/API/colores/guardar', [ColoresController::class, 'guardarAPI'] );
$router->get('/API/colores/buscar', [ColoresController::class, 'buscarAPI'] );
$router->post('/API/colores/modificar', [ColoresController::class, 'modificarAPI'] );
$router->post('/API/colores/eliminar', [ColoresController::class, 'eliminarAPI'] );


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
$router->post('/API/delitos/situacion', [DelitosController::class, 'cambioSituacionAPI'] );

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


$router->post('/API/migrantes/guardar', [MigrantesController::class, 'guardar']);
$router->post('/API/migrantes/modificar', [MigrantesController::class, 'modificar']);
$router->get('/API/migrantes/buscar', [MigrantesController::class, 'buscarMigrantesAPI']);
$router->get('/API/migrantes/buscarEdad', [MigrantesController::class, 'buscarEdadAPI']);
$router->get('/API/migrantes/buscarPais', [MigrantesController::class, 'buscarPaisAPI']);

$router->post('/API/migrantes/eliminar', [MigrantesController::class, 'eliminarMigrante']);

$router->post('/API/migrantes/migrantes/eliminar', [MigrantesController::class, 'eliminarMigrantes']);


$router->post('/API/dinero/guardar', [DineroController::class, 'guardar']);
$router->post('/API/dinero/modificar', [DineroController::class, 'modificar']);
$router->get('/API/dinero/buscar', [DineroController::class, 'buscarDineroAPI']);
$router->post('/API/dinero/eliminar', [DineroController::class, 'eliminarDinero']);
$router->post('/API/dinero/dinero/eliminar', [DineroController::class, 'eliminarDineros']);

$router->post('/API/des_natural/guardar', [Des_naturalController::class, 'guardar']);
$router->post('/API/des_natural/modificar', [Des_naturalController::class, 'modificar']);
$router->get('/API/des_natural/buscar', [Des_naturalController::class, 'buscarDesastresAPI']);
$router->post('/API/des_natural/eliminar', [Des_naturalController::class, 'eliminarDesastre']);

$router->post('/API/pistas/guardar', [PistasController::class, 'guardar']);
$router->post('/API/pistas/modificar', [PistasController::class, 'modificar']);
$router->get('/API/pistas/buscar', [PistasController::class, 'buscarPistasAPI']);
$router->post('/API/pistas/eliminar', [PistasController::class, 'eliminarPistas']);

$router->post('/API/mov_social/guardar', [Mov_socialController::class, 'guardar']);
$router->post('/API/mov_social/modificar', [Mov_socialController::class, 'modificar']);
$router->get('/API/mov_social/buscar', [Mov_socialController::class, 'buscarMovimientoAPI']);
$router->post('/API/mov_social/eliminar', [Mov_socialController::class, 'eliminarMovimiento']);




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
$router->post('/API/incautacion/modificar', [IncautacionController::class, 'modificar']);
$router->get('/API/incautacion/buscar', [IncautacionController::class, 'buscarIncautacionAPI']);
$router->post('/API/incautacion/eliminar', [IncautacionController::class, 'eliminarIncautacion']);

$router->post('/API/incautacion_Fuentes1/guardar', [IncautacionFuentes1Controller::class, 'guardar']);
$router->post('/API/incautacion_Fuentes1/modificar', [IncautacionFuentes1Controller::class, 'modificar']);
$router->get('/API/incautacion_Fuentes1/buscar', [IncautacionFuentes1Controller::class, 'buscarIncautacionAPI']);
$router->post('/API/incautacion_Fuentes1/eliminar', [IncautacionFuentes1Controller::class, 'eliminarIncautacion']);
$router->post('/API/incautacion_Fuentes1/Fuentes1/eliminar', [IncautacionFuentes1Controller::class, 'eliminarArma']);
$router->post('/API/incautacion_Fuentes1/municion/eliminar', [IncautacionFuentes1Controller::class, 'eliminarMunicion']);


// MAPA CALOR MUERTES



$router->get('/mapas/muertes', [infoMuertesController::class , 'index']);
$router->post('/API/mapas/IndexMuertes/resumen', [infoMuertesController::class , 'resumenAPI'] );
$router->get('/API/mapas/IndexMuertes/listado', [infoMuertesController::class , 'listadoAPI'] );
$router->post('/API/mapas/IndexMuertes/modal', [infoMuertesController::class , 'modalAPI'] );
$router->post('/API/mapas/IndexMuertes/informacion', [infoMuertesController::class , 'informacionModalAPI'] );
$router->post('/API/mapas/IndexMuertes/informacion1', [infoMuertesController::class , 'informacionModalAPI1'] );
$router->post('/API/mapas/IndexMuertes/mapaCalor', [infoMuertesController::class , 'mapaCalorAPI'] );
$router->post('/API/mapas/IndexMuertes/mapaCalorPorDepto', [infoMuertesController::class , 'mapaCalorDeptoAPI'] );
$router->post('/API/mapas/IndexMuertes/colores', [infoMuertesController::class , 'coloresAPI'] );
$router->post('/API/mapas/IndexMuertes/mapaCalorPorDeptoGrafica', [infoMuertesController::class , 'mapaCalorPorDeptoGraficaAPI'] );


$router->get('/reportes/topico', [ReporteController::class, 'reporteTopico']);
$router->get('/reportes/general', [ReporteController::class, 'reporteGeneral']);


$router->get('/mapas/droga', [infoDrogaController::class , 'index']);
$router->post('/API/mapas/infoDroga/resumen', [infoDrogaController::class , 'resumenAPI'] );
$router->get('/API/mapas/infoDroga/listado', [infoDrogaController::class , 'listadoAPI'] );
$router->post('/API/mapas/infoDroga/modal', [infoDrogaController::class , 'modalAPI'] );
$router->post('/API/mapas/infoDroga/informacion', [infoDrogaController::class , 'informacionModalAPI'] );
$router->post('/API/mapas/infoDroga/informacion1', [infoDrogaController::class , 'informacionModalAPI1'] );
$router->post('/API/mapas/infoDroga/informacionPersonas', [infoDrogaController::class , 'informacionPersonasAPI'] );
$router->post('/API/mapas/infoDroga/distanciaPista', [infoDrogaController::class , 'distanciaPistaAPI'] );
$router->post('/API/mapas/infoDroga/mapaCalor', [infoDrogaController::class , 'mapaCalorAPI'] );
$router->post('/API/mapas/infoDroga/colores', [infoDrogaController::class , 'coloresAPI'] );
$router->post('/API/mapas/infoDroga/mapaCalorPorDepto', [infoDrogaController::class , 'mapaCalorDeptoAPI'] );
$router->post('/API/mapas/infoDroga/mapaCalorPorDeptoGrafica', [infoDrogaController::class , 'mapaCalorPorDeptoGraficaAPI'] );
$router->post('/API/mapas/infoDroga/mapaCalorPorDeptoPistas', [infoDrogaController::class , 'mapaCalorPorDeptoPistasAPI'] );
$router->post('/API/mapas/infoDroga/DrogasCantGrafica', [infoDrogaController::class , 'DrogasCantGraficaAPI'] );
$router->post('/API/mapas/infoDroga/DrogasDepartamentoGrafica', [infoDrogaController::class , 'DrogasDepartamentoGraficaAPI'] );
$router->post('/API/mapas/infoDroga/IncautacionesPorDiaGrafica', [infoDrogaController::class , 'IncautacionesPorDiaGraficaAPI'] );
$router->post('/API/mapas/infoDroga/KilosPorDiaGrafica', [infoDrogaController::class , 'KilosPorDiaGraficaAPI'] );
$router->post('/API/mapas/infoDroga/MatasPorDiaGrafica', [infoDrogaController::class , 'MatasPorDiaGraficaAPI'] );
$router->post('/API/mapas/infoDroga/GraficatrimestralKilos', [infoDrogaController::class , 'GraficatrimestralKilosAPI'] );
$router->post('/API/mapas/infoDroga/GraficatrimestralMatas', [infoDrogaController::class , 'GraficatrimestralMatasAPI'] );
$router->post('/API/mapas/infoDroga/GraficatrimestralPistas', [infoDrogaController::class , 'GraficatrimestralPistasAPI'] );
$router->post('/API/mapas/infoDroga/GraficaTrimestralIncautacionesGeneral', [infoDrogaController::class , 'GraficaTrimestralIncautacionesGeneralAPI'] );



$router->get('/mapas/maras', [infoMarasController::class , 'index']);
$router->post('/API/mapas/infoMaras/resumen', [infoMarasController::class , 'resumenAPI'] );
$router->get('/API/mapas/infoMaras/listado', [infoMarasController::class , 'listadoAPI'] );
$router->post('/API/mapas/infoMaras/modal', [infoMarasController::class , 'modalAPI'] );
$router->post('/API/mapas/infoMaras/informacionCapturas', [infoMarasController::class , 'informacionCapturasModalAPI'] );
$router->post('/API/mapas/infoMaras/informacionDroga', [infoMarasController::class , 'informacionDrogaModalAPI'] );
$router->post('/API/mapas/infoMaras/informacionMuerte', [infoMarasController::class , 'informacionMuerteModalAPI'] );
$router->post('/API/mapas/infoMaras/informacionDinero', [infoMarasController::class , 'informacionDineroModalAPI'] );
$router->post('/API/mapas/infoMaras/informacionFuentes1', [infoMarasController::class , 'informacionFuentes1ModalAPI'] );
$router->post('/API/mapas/infoMaras/informacionMunicion', [infoMarasController::class , 'informacionMunicionModalAPI'] );
$router->post('/API/mapas/infoMaras/mapaCalor', [infoMarasController::class , 'mapaCalorAPI'] );
$router->post('/API/mapas/infoMaras/mapaCalorPorDepto', [infoMarasController::class , 'mapaCalorDeptoAPI'] );
$router->post('/API/mapas/infoMaras/mapaCalorPorDeptoGrafica', [infoMarasController::class , 'mapaCalorPorDeptoGraficaAPI'] );
$router->post('/API/mapas/infoMaras/colores', [infoMarasController::class , 'coloresAPI'] );
$router->post('/API/mapas/infoMaras/DelitosCantGrafica', [infoMarasController::class , 'DelitosCantGraficaAPI'] );
$router->post('/API/mapas/infoMaras/DelitosDepartamentoGrafica', [infoMarasController::class , 'DelitosDepartamentoGraficaAPI'] );
$router->post('/API/mapas/infoMaras/ActividadesPorDiaGrafica', [infoMarasController::class , 'ActividadesPorDiaGraficaAPI'] );
$router->post('/API/mapas/infoMaras/Mara18PorDiaGrafica', [infoMarasController::class , 'Mara18PorDiaGraficaAPI'] );
$router->post('/API/mapas/infoMaras/SalvatruchaPorDiaGrafica', [infoMarasController::class , 'SalvatruchaPorDiaGraficaAPI'] );
$router->post('/API/mapas/infoMaras/GraficaTrimestralMara18', [infoMarasController::class , 'GraficaTrimestralMara18API'] );
$router->post('/API/mapas/infoMaras/GraficaTrimestralSalvatrucha', [infoMarasController::class , 'GraficaTrimestralSalvatruchaAPI'] );
$router->post('/API/mapas/infoMaras/GraficaTrimestralGeneral', [infoMarasController::class , 'GraficaTrimestralGeneralAPI'] );



$router->get('/mapas/migrantes', [infoMigrantesController::class , 'index']);
$router->post('/API/mapas/infoMigrantes/resumen', [infoMigrantesController::class , 'resumenAPI'] );
$router->get('/API/mapas/infoMigrantes/listado', [infoMigrantesController::class , 'listadoAPI'] );
$router->post('/API/mapas/infoMigrantes/modal', [infoMigrantesController::class , 'modalAPI'] );
$router->post('/API/mapas/infoMigrantes/informacionMigrantes', [infoMigrantesController::class , 'informacionMigrantesModalAPI'] );
$router->post('/API/mapas/infoMigrantes/mapaCalor', [infoMigrantesController::class , 'mapaCalorAPI'] );
$router->post('/API/mapas/infoMigrantes/mapaCalorPorDepto', [infoMigrantesController::class , 'mapaCalorDeptoAPI'] );
$router->post('/API/mapas/infoMigrantes/mapaCalorPorDeptoGrafica', [infoMigrantesController::class , 'mapaCalorPorDeptoGraficaAPI'] );
$router->post('/API/mapas/infoMigrantes/colores', [infoMigrantesController::class , 'coloresAPI'] );
$router->post('/API/mapas/infoMigrantes/MigrantesCantGrafica', [infoMigrantesController::class , 'MigrantesCantGraficaAPI'] );
$router->post('/API/mapas/infoMigrantes/MigrantesDepartamentoGrafica', [infoMigrantesController::class , 'MigrantesDepartamentoGraficaAPI'] );
$router->post('/API/mapas/infoMigrantes/MigrantesPorDiaGrafica', [infoMigrantesController::class , 'MigrantesPorDiaGraficaAPI'] );
$router->post('/API/mapas/infoMigrantes/GraficaTrimestral', [infoMigrantesController::class , 'GraficaTrimestralAPI'] );
$router->post('/API/mapas/infoMigrantes/GraficaTrimestralGeneral', [infoMigrantesController::class , 'GraficaTrimestralGeneralAPI'] );

////////Fuentes1

$router->get('/Fuentes', [FuentesController::class , 'index']);
$router->post('/API/Fuentes/guardar', [FuentesController::class, 'guardarAPI'] );
$router->get('/API/Fuentes/buscar', [FuentesController::class, 'buscarAPI'] );
$router->post('/API/Fuentes/modificar', [FuentesController::class, 'modificarAPI'] );
$router->post('/API/Fuentes/eliminar', [FuentesController::class, 'eliminarAPI'] );
$router->post('/API/Fuentes/situacion', [FuentesController::class, 'cambioSituacionAPI'] );
$router->post('/API/Fuentes/estado', [FuentesController::class, 'cambioestadoAPI'] );



// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();
