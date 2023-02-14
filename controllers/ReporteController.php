<?php

namespace Controllers;

use Classes\Reporte;
use Exception;
use Model\Capturados;
use Model\Evento;
use Mpdf\Mpdf;
use MVC\Router;

class ReporteController{

    public static function reporteTopico(Router $router){
        $inicio = $_GET['inicio'];
        $fin = $_GET['fin'];
        $id = $_GET['id'];
        $user = $_SESSION['auth_user'];

        $userInfo = array_shift(Evento::fetchArray("SELECT * from mper inner join morg on per_plaza = org_plaza inner join mdep on org_dependencia = dep_llave where per_catalogo = $user "));
        $reporte = new Reporte($router, $userInfo);
        $pdf = $reporte->generatePDF();
        $pdf->AddPage('P');

        $evento = array_shift(Evento::fetchArray("SELECT amc_topico.tipo as tipo_id, amc_topico.info ,amc_topico.fecha as fecha, amc_topico.lugar as lugar, amc_topico.latitud, amc_topico.longitud, amc_tipo_topics.desc as tipo, amc_actividad_vinculada.desc as actividad, dm_mun_dep as municipio
                                                    FROM amc_topico 
                                                    inner join amc_tipo_topics on amc_topico.tipo = amc_tipo_topics.id 
                                                    inner join depmun on municipio = dm_codigo 
                                                    inner join amc_actividad_vinculada on amc_topico.actividad = amc_actividad_vinculada.id
                                                    where amc_topico.id = $id
                                                "));

        switch ($evento['tipo_id']) {
            case '1':
                // $capturados = array_shift(Capturados::fetchArray("SELECT * FROM "));
                $detalle = $router->load('reportes/captura', [
                    // 'capturados' => $capturados,
                ]);
                break;
            case '2':
                $detalle = "2";
                break;
            
            default:
                # code...
                break;
        }

        $contenido = $router->load('reportes/topico', [
            'evento' => $evento,
        ]);


        $pdf->WriteHTML($contenido);
        $pdf->WriteHTML($detalle);
        


        $pdf->Output();
    }
}