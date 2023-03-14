<?php 
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(0);
require_once __DIR__ . '/../includes/app.php';
date_default_timezone_set('America/Guatemala');
setlocale(LC_ALL, 'es_ES');
use Controllers\usuariosController;
use Controllers\ArmasController;
use Controllers\CalibresController;
use Controllers\CapturaController;
use Controllers\DelitosController;


use Controllers\EventoController;
use Controllers\IncautacionArmasController;
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



use Controllers\InfoCapturaController;
use Controllers\InfoMuertesController;
use Controllers\InfoDrogaController;
use Controllers\InfoDesastresController;
use Controllers\Mov_socialController;
use Controllers\PistasController;
use Controllers\InfoMarasController;
use Controllers\InfoDinero_y_armasController;
use Controllers\InfoMigrantesController;
use Controllers\FuentesController;


$router = new Router();
$router->setBaseURL('/medios-comunicacion');

$router->get('/', [AppController::class,'index']);
$router->get('/cerrar-sesion', [AppController::class,'cerrarSesion']);


$router->get('/usuarios',[usuariosController::class,'index']);
$router->post('/API/usuarios/guardar', [usuariosController::class, 'guardarAPI'] );
$router->get('/API/usuarios/buscar', [usuariosController::class, 'buscarAPI'] );
$router->post('/API/usuarios/modificar', [usuariosController::class, 'modificarAPI'] );
$router->post('/API/usuarios/eliminar', [usuariosController::class, 'eliminarAPI'] );
$router->post('/API/usuarios/cambiarSituacion', [usuariosController::class, 'cambioSituacionAPI'] );

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
$router->post('/API/armas/cambiarSituacion', [ArmasController::class, 'cambioSituacionAPI'] );


$router->get('/calibres', [CalibresController::class , 'index']);
$router->post('/API/calibres/guardar', [CalibresController::class, 'guardarAPI'] );
$router->get('/API/calibres/buscar', [CalibresController::class, 'buscarAPI'] );
$router->post('/API/calibres/modificar', [CalibresController::class, 'modificarAPI'] );
$router->post('/API/calibres/eliminar', [CalibresController::class, 'eliminarAPI'] );
$router->post('/API/calibres/cambiarSituacion', [CalibresController::class, 'cambiarSituacionAPI'] );


$router->get('-s', [DelitosController::class , 'index']);
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
$router->post('/API/moneda/cambiarSituacion', [MonedaController::class, 'cambiarSituacionAPI'] );



$router->get('/organizacion', [OrganizacionController::class , 'index']);
$router->post('/API/organizacion/guardar', [OrganizacionController::class, 'guardarAPI'] );
$router->get('/API/organizacion/buscar', [OrganizacionController::class, 'buscarAPI'] );
$router->post('/API/organizacion/modificar', [OrganizacionController::class, 'modificarAPI'] );
$router->post('/API/organizacion/eliminar', [OrganizacionController::class, 'eliminarAPI'] );
$router->post('/API/organizacion/cambiarSituacion', [OrganizacionController::class, 'cambiarSituacionAPI'] );

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
$router->post('/API/nacionalidad/cambiarSituacion', [NacionalidadController::class, 'cambioSituacionAPI'] );


$router->get('/eventos', [EventoController::class,'index']);
$router->get('/API/eventos', [EventoController::class,'eventos']);
$router->get('/API/eventos/find', [EventoController::class,'getEventoIdApi']);
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
$router->post('/API/mov_social/', [Mov_socialController::class, 'cambiarSituacion']);




$router->get('/mapas/capturas', [InfoCapturaController::class , 'index']);
$router->post('/API/mapas/infoCapturas/resumen', [InfoCapturaController::class , 'resumenAPI'] );
$router->get('/API/mapas/infoCapturas/listado', [InfoCapturaController::class , 'listadoAPI'] );
$router->post('/API/mapas/infoCapturas/modal', [InfoCapturaController::class , 'modalAPI'] );
$router->post('/API/mapas/infoCapturas/informacion', [InfoCapturaController::class , 'informacionModalAPI'] );
$router->post('/API/mapas/infoCapturas/informacion1', [InfoCapturaController::class , 'informacionModalAPI1'] );
$router->post('/API/mapas/infoCapturas/mapaCalor', [InfoCapturaController::class , 'mapaCalorAPI'] );
$router->post('/API/mapas/infoCapturas/mapaCalorPorDepto', [InfoCapturaController::class , 'mapaCalorDeptoAPI'] );
$router->post('/API/mapas/infoCapturas/mapaCalorPorDeptoGrafica', [InfoCapturaController::class , 'mapaCalorPorDeptoGraficaAPI'] );
$router->post('/API/mapas/infoCapturas/colores', [InfoCapturaController::class , 'coloresAPI'] );
$router->post('/API/mapas/infoCapturas/DelitosCantGrafica', [InfoCapturaController::class , 'DelitosCantGraficaAPI'] );
$router->post('/API/mapas/infoCapturas/DelitosDepartamentoGrafica', [InfoCapturaController::class , 'DelitosDepartamentoGraficaAPI'] );
$router->post('/API/mapas/infoCapturas/CapturasPorDiaGrafica', [InfoCapturaController::class , 'CapturasPorDiaGraficaAPI'] );
$router->post('/API/mapas/infoCapturas/GraficaTrimestral', [InfoCapturaController::class , 'GraficaTrimestralAPI'] );
$router->post('/API/mapas/infoCapturas/GraficaTrimestralGeneral', [InfoCapturaController::class , 'GraficaTrimestralGeneralAPI'] );

$router->post('/API/incautacion/guardar', [IncautacionController::class, 'guardar']);
$router->post('/API/incautacion/modificar', [IncautacionController::class, 'modificar']);
$router->get('/API/incautacion/buscar', [IncautacionController::class, 'buscarIncautacionAPI']);
$router->post('/API/incautacion/eliminar', [IncautacionController::class, 'eliminarIncautacion']);

$router->post('/API/incautacion_armas/guardar', [IncautacionArmasController::class, 'guardar']);
$router->post('/API/incautacion_armas/modificar', [IncautacionArmasController::class, 'modificar']);
$router->get('/API/incautacion_armas/buscar', [IncautacionArmasController::class, 'buscarIncautacionAPI']);
$router->post('/API/incautacion_armas/eliminar', [IncautacionArmasController::class, 'eliminarIncautacion']);
$router->post('/API/incautacion_armas/armas/eliminar', [IncautacionArmasController::class, 'eliminarArma']);
$router->post('/API/incautacion_armas/municion/eliminar', [IncautacionArmasController::class, 'eliminarMunicion']);


// MAPA CALOR MUERTES



$router->get('/mapas/muertes', [InfoMuertesController::class , 'index']);
$router->post('/API/mapas/IndexMuertes/resumen', [InfoMuertesController::class , 'resumenAPI'] );
$router->get('/API/mapas/IndexMuertes/listado', [InfoMuertesController::class , 'listadoAPI'] );
$router->post('/API/mapas/IndexMuertes/modal', [InfoMuertesController::class , 'modalAPI'] );
$router->post('/API/mapas/IndexMuertes/informacion', [InfoMuertesController::class , 'informacionModalAPI'] );
// $router->post('/API/mapas/IndexMuertes/informacion1', [InfoMuertesController::class , 'informacionModalAPI1'] );
$router->post('/API/mapas/IndexMuertes/mapaCalor', [InfoMuertesController::class , 'mapaCalorAPI'] );
$router->post('/API/mapas/IndexMuertes/mapaCalorPorDepto', [InfoMuertesController::class , 'mapaCalorDeptoAPI'] );
$router->post('/API/mapas/IndexMuertes/colores', [InfoMuertesController::class , 'coloresAPI'] );
$router->post('/API/mapas/IndexMuertes/mapaCalorPorDeptoGrafica', [InfoMuertesController::class , 'mapaCalorPorDeptoGraficaAPI'] );
$router->post('/API/mapas/IndexMuertes/GraficaTrimestralGeneral', [InfoMuertesController::class , 'GraficaTrimestralGeneralAPI'] );
$router->post('/API/mapas/IndexMuertes/DelitosCantGrafica', [InfoMuertesController::class , 'DelitosCantGraficaAPI'] );
$router->post('/API/mapas/IndexMuertes/DelitosDepartamentoGrafica', [InfoMuertesController::class , 'DelitosDepartamentoGraficaAPI'] );
$router->post('/API/mapas/IndexMuertes/CapturasPorDiaGrafica', [InfoMuertesController::class , 'CapturasPorDiaGraficaAPI'] );
$router->post('/API/mapas/IndexMuertes/GraficaTrimestral', [InfoMuertesController::class , 'GraficaTrimestralAPI'] );



//DINERO_Y_ARMAS
$router->get('/mapas/dinero_y_armas', [InfoDinero_y_armasController::class , 'index']);
$router->post('/API/mapas/IndexDinero_y_armas/resumen', [InfoDinero_y_armasController::class , 'resumenAPI'] );
$router->get('/API/mapas/IndexDinero_y_armas/listado', [InfoDinero_y_armasController::class , 'listadoAPI'] );
$router->post('/API/mapas/IndexDinero_y_armas/modal', [InfoDinero_y_armasController::class , 'modalAPI'] );
$router->post('/API/mapas/IndexDinero_y_armas/informacion', [InfoDinero_y_armasController::class , 'informacionModalAPI'] );
$router->post('/API/mapas/IndexDinero_y_armas/informacion1', [InfoDinero_y_armasController::class , 'informacionModalAPI1'] );
$router->post('/API/mapas/IndexDinero_y_armas/mapaCalor', [InfoDinero_y_armasController::class , 'mapaCalorAPI'] );
$router->post('/API/mapas/IndexDinero_y_armas/mapaCalorPorDepto', [InfoDinero_y_armasController::class , 'mapaCalorDeptoAPI'] );
$router->post('/API/mapas/IndexDinero_y_armas/colores', [InfoDinero_y_armasController::class , 'coloresAPI'] );
$router->post('/API/mapas/IndexDinero_y_armas/mapaCalorPorDeptoGrafica', [InfoDinero_y_armasController::class , 'mapaCalorPorDeptoGraficaAPI'] );
$router->post('/API/mapas/IndexDinero_y_armas/GraficaTrimestralGeneral', [InfoDinero_y_armasController::class , 'GraficaTrimestralGeneralAPI'] );
$router->post('/API/mapas/IndexDinero_y_armas/DelitosCantGrafica', [InfoDinero_y_armasController::class , 'DelitosCantGraficaAPI'] );
$router->post('/API/mapas/IndexDinero_y_armas/DineroCantGrafica', [InfoDinero_y_armasController::class , 'DineroCantGraficaAPI'] );
$router->post('/API/mapas/IndexDinero_y_armas/DelitosDepartamentoGrafica', [InfoDinero_y_armasController::class , 'DelitosDepartamentoGraficaAPI'] );

$router->post('/API/mapas/IndexDinero_y_armas/DineroDepartamentoGrafica', [InfoDinero_y_armasController::class , 'DineroDepartamentoGraficaAPI'] );
$router->post('/API/mapas/IndexDinero_y_armas/CapturasPorDiaGrafica', [InfoDinero_y_armasController::class , 'CapturasPorDiaGraficaAPI'] );
$router->post('/API/mapas/IndexDinero_y_armas/CapturasPorDiaGrafica_armas', [InfoDinero_y_armasController::class , 'CapturasPorDiaGrafica_armasAPI'] );
$router->post('/API/mapas/IndexDinero_y_armas/GraficaTrimestral', [InfoDinero_y_armasController::class , 'GraficaTrimestralAPI'] );
$router->post('/API/mapas/IndexDinero_y_armas/GraficaTrimestralGeneral', [InfoDinero_y_armasController::class , 'GraficaTrimestralGeneralAPI'] );



$router->get('/reportes/topico', [ReporteController::class, 'reporteTopico']);
$router->get('/reportes/general', [ReporteController::class, 'reporteGeneral']);


$router->get('/mapas/droga', [InfoDrogaController::class , 'index']);
$router->post('/API/mapas/infoDroga/resumen', [InfoDrogaController::class , 'resumenAPI'] );
$router->get('/API/mapas/infoDroga/listado', [InfoDrogaController::class , 'listadoAPI'] );
$router->post('/API/mapas/infoDroga/modal', [InfoDrogaController::class , 'modalAPI'] );
$router->post('/API/mapas/infoDroga/informacion', [InfoDrogaController::class , 'informacionModalAPI'] );
$router->post('/API/mapas/infoDroga/informacion1', [InfoDrogaController::class , 'informacionModalAPI1'] );
$router->post('/API/mapas/infoDroga/informacionPersonas', [InfoDrogaController::class , 'informacionPersonasAPI'] );
$router->post('/API/mapas/infoDroga/distanciaPista', [InfoDrogaController::class , 'distanciaPistaAPI'] );
$router->post('/API/mapas/infoDroga/mapaCalor', [InfoDrogaController::class , 'mapaCalorAPI'] );
$router->post('/API/mapas/infoDroga/colores', [InfoDrogaController::class , 'coloresAPI'] );
$router->post('/API/mapas/infoDroga/mapaCalorPorDepto', [InfoDrogaController::class , 'mapaCalorDeptoAPI'] );
$router->post('/API/mapas/infoDroga/mapaCalorPorDeptoGrafica', [InfoDrogaController::class , 'mapaCalorPorDeptoGraficaAPI'] );
$router->post('/API/mapas/infoDroga/mapaCalorPorDeptoPistas', [InfoDrogaController::class , 'mapaCalorPorDeptoPistasAPI'] );
$router->post('/API/mapas/infoDroga/DrogasCantGrafica', [InfoDrogaController::class , 'DrogasCantGraficaAPI'] );
$router->post('/API/mapas/infoDroga/DrogasDepartamentoGrafica', [InfoDrogaController::class , 'DrogasDepartamentoGraficaAPI'] );
$router->post('/API/mapas/infoDroga/IncautacionesPorDiaGrafica', [InfoDrogaController::class , 'IncautacionesPorDiaGraficaAPI'] );
$router->post('/API/mapas/infoDroga/KilosPorDiaGrafica', [InfoDrogaController::class , 'KilosPorDiaGraficaAPI'] );
$router->post('/API/mapas/infoDroga/MatasPorDiaGrafica', [InfoDrogaController::class , 'MatasPorDiaGraficaAPI'] );
$router->post('/API/mapas/infoDroga/GraficatrimestralKilos', [InfoDrogaController::class , 'GraficatrimestralKilosAPI'] );
$router->post('/API/mapas/infoDroga/GraficatrimestralMatas', [InfoDrogaController::class , 'GraficatrimestralMatasAPI'] );
$router->post('/API/mapas/infoDroga/GraficatrimestralPistas', [InfoDrogaController::class , 'GraficatrimestralPistasAPI'] );
$router->post('/API/mapas/infoDroga/GraficaTrimestralIncautacionesGeneral', [InfoDrogaController::class , 'GraficaTrimestralIncautacionesGeneralAPI'] );



$router->get('/mapas/maras', [InfoMarasController::class , 'index']);
$router->post('/API/mapas/infoMaras/resumen', [InfoMarasController::class , 'resumenAPI'] );
$router->get('/API/mapas/infoMaras/listado', [InfoMarasController::class , 'listadoAPI'] );
$router->post('/API/mapas/infoMaras/modal', [InfoMarasController::class , 'modalAPI'] );
$router->post('/API/mapas/infoMaras/informacionCapturas', [InfoMarasController::class , 'informacionCapturasModalAPI'] );
$router->post('/API/mapas/infoMaras/informacionDroga', [InfoMarasController::class , 'informacionDrogaModalAPI'] );
$router->post('/API/mapas/infoMaras/informacionMuerte', [InfoMarasController::class , 'informacionMuerteModalAPI'] );
$router->post('/API/mapas/infoMaras/informacionDinero', [InfoMarasController::class , 'informacionDineroModalAPI'] );
$router->post('/API/mapas/infoMaras/informacionArmas', [InfoMarasController::class , 'informacionArmasModalAPI'] );
$router->post('/API/mapas/infoMaras/informacionMunicion', [InfoMarasController::class , 'informacionMunicionModalAPI'] );
$router->post('/API/mapas/infoMaras/mapaCalor', [InfoMarasController::class , 'mapaCalorAPI'] );
$router->post('/API/mapas/infoMaras/mapaCalorPorDepto', [InfoMarasController::class , 'mapaCalorDeptoAPI'] );
$router->post('/API/mapas/infoMaras/mapaCalorPorDeptoGrafica', [InfoMarasController::class , 'mapaCalorPorDeptoGraficaAPI'] );
$router->post('/API/mapas/infoMaras/colores', [InfoMarasController::class , 'coloresAPI'] );
$router->post('/API/mapas/infoMaras/DelitosCantGrafica', [InfoMarasController::class , 'DelitosCantGraficaAPI'] );
$router->post('/API/mapas/infoMaras/DelitosDepartamentoGrafica', [InfoMarasController::class , 'DelitosDepartamentoGraficaAPI'] );
$router->post('/API/mapas/infoMaras/ActividadesPorDiaGrafica', [InfoMarasController::class , 'ActividadesPorDiaGraficaAPI'] );
$router->post('/API/mapas/infoMaras/Mara18PorDiaGrafica', [InfoMarasController::class , 'Mara18PorDiaGraficaAPI'] );
$router->post('/API/mapas/infoMaras/SalvatruchaPorDiaGrafica', [InfoMarasController::class , 'SalvatruchaPorDiaGraficaAPI'] );
$router->post('/API/mapas/infoMaras/GraficaTrimestralMara18', [InfoMarasController::class , 'GraficaTrimestralMara18API'] );
$router->post('/API/mapas/infoMaras/GraficaTrimestralSalvatrucha', [InfoMarasController::class , 'GraficaTrimestralSalvatruchaAPI'] );
$router->post('/API/mapas/infoMaras/GraficaTrimestralGeneral', [InfoMarasController::class , 'GraficaTrimestralGeneralAPI'] );



$router->get('/mapas/migrantes', [InfoMigrantesController::class , 'index']);
$router->post('/API/mapas/infoMigrantes/resumen', [InfoMigrantesController::class , 'resumenAPI'] );
$router->get('/API/mapas/infoMigrantes/listado', [InfoMigrantesController::class , 'listadoAPI'] );
$router->post('/API/mapas/infoMigrantes/modal', [InfoMigrantesController::class , 'modalAPI'] );
$router->post('/API/mapas/infoMigrantes/informacionMigrantes', [InfoMigrantesController::class , 'informacionMigrantesModalAPI'] );
$router->post('/API/mapas/infoMigrantes/mapaCalor', [InfoMigrantesController::class , 'mapaCalorAPI'] );
$router->post('/API/mapas/infoMigrantes/mapaCalorPorDepto', [InfoMigrantesController::class , 'mapaCalorDeptoAPI'] );
$router->post('/API/mapas/infoMigrantes/mapaCalorPorDeptoGrafica', [InfoMigrantesController::class , 'mapaCalorPorDeptoGraficaAPI'] );
$router->post('/API/mapas/infoMigrantes/colores', [InfoMigrantesController::class , 'coloresAPI'] );
$router->post('/API/mapas/infoMigrantes/MigrantesCantGrafica', [InfoMigrantesController::class , 'MigrantesCantGraficaAPI'] );
$router->post('/API/mapas/infoMigrantes/MigrantesDepartamentoGrafica', [InfoMigrantesController::class , 'MigrantesDepartamentoGraficaAPI'] );
$router->post('/API/mapas/infoMigrantes/MigrantesPorDiaGrafica', [InfoMigrantesController::class , 'MigrantesPorDiaGraficaAPI'] );
$router->post('/API/mapas/infoMigrantes/GraficaTrimestral', [InfoMigrantesController::class , 'GraficaTrimestralAPI'] );
$router->post('/API/mapas/infoMigrantes/GraficaTrimestralGeneral', [InfoMigrantesController::class , 'GraficaTrimestralGeneralAPI'] );



$router->get('/mapas/desastres', [InfoDesastresController::class , 'index']);
$router->post('/API/mapas/infoDesastres/resumen', [InfoDesastresController::class , 'resumenAPI'] );
$router->get('/API/mapas/infoDesastres/listado', [InfoDesastresController::class , 'listadoAPI'] );
$router->post('/API/mapas/infoDesastres/modal', [InfoDesastresController::class , 'modalAPI'] );
$router->post('/API/mapas/infoDesastres/informacion', [InfoDesastresController::class , 'informacionModalAPI'] );
$router->post('/API/mapas/infoDesastres/mapaCalor', [InfoDesastresController::class , 'mapaCalorAPI'] );
$router->post('/API/mapas/infoDesastres/mapaCalorPorDepto', [InfoDesastresController::class , 'mapaCalorDeptoAPI'] );
$router->post('/API/mapas/infoDesastres/mapaCalorPorDeptoGrafica', [InfoDesastresController::class , 'mapaCalorPorDeptoGraficaAPI'] );
$router->post('/API/mapas/infoDesastres/colores', [InfoDesastresController::class , 'coloresAPI'] );
$router->post('/API/mapas/infoDesastres/DesatresCantGrafica', [InfoDesastresController::class , 'DesastresCantGraficaAPI'] );
$router->post('/API/mapas/infoDesastres/MigrantesDepartamentoGrafica', [InfoDesastresController::class , 'MigrantesDepartamentoGraficaAPI'] );
$router->post('/API/mapas/infoDesastres/MigrantesPorDiaGrafica', [InfoDesastresController::class , 'MigrantesPorDiaGraficaAPI'] );
$router->post('/API/mapas/infoDesastres/GraficaTrimestral', [InfoDesastresController::class , 'GraficaTrimestralAPI'] );
$router->post('/API/mapas/infoDesastres/GraficaTrimestralGeneral', [InfoDesastresController::class , 'GraficaTrimestralGeneralAPI'] );



$router->get('/Fuentes', [FuentesController::class , 'index']);
$router->post('/API/Fuentes/guardar', [FuentesController::class, 'guardarAPI'] );
$router->get('/API/Fuentes/buscar', [FuentesController::class, 'buscarAPI'] );
$router->post('/API/Fuentes/modificar', [FuentesController::class, 'modificarAPI'] );
$router->post('/API/Fuentes/eliminar', [FuentesController::class, 'eliminarAPI'] );
$router->post('/API/Fuentes/situacion', [FuentesController::class, 'cambioSituacionAPI'] );
$router->post('/API/Fuentes/estado', [FuentesController::class, 'cambioestadoAPI'] );

// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();
