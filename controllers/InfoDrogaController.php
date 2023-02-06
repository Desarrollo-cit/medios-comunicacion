<?php

namespace Controllers;

use Exception;
use DateTime;
use Model\Capturadas;
use Model\Delito;
use Model\DepMun;
// use Model\Delito;
use MVC\Router;

class InfoDrogaController
{
    public function index(Router $router)
    {
        // $capturas = static::cantidadCapturas();
        // $mujeres = static::mujeres();
        // $hombres = static::hombres();
        // $depto = static::departamento_capturas();
        // $delito = static::delitoIncurrente();
        // $colores = static::coloresAPI1();
        // $delitos = static::delitosApi();
        $router->render('mapas/droga', [
            // 'capturas' => $capturas,
            // 'delito' => $delito,
            // 'delitos' => $delitos,
            // 'mujeres' => $mujeres,
            // 'hombres' => $hombres,
            // 'depto' => $depto,
            // 'colores' => $colores,
        ]);
    }
}