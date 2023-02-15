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

        $evento = array_shift(Evento::fetchArray("SELECT amc_topico.tipo as tipo_id, amc_topico.info ,amc_topico.fecha as fecha, amc_topico.lugar as lugar, amc_topico.latitud, amc_topico.longitud, amc_tipo_topics.desc as tipo, amc_actividad_vinculada.desc as actividad, dm_mun_dep as municipio
                                                    FROM amc_topico 
                                                    inner join amc_tipo_topics on amc_topico.tipo = amc_tipo_topics.id 
                                                    inner join depmun on municipio = dm_codigo 
                                                    inner join amc_actividad_vinculada on amc_topico.actividad = amc_actividad_vinculada.id
                                                    where amc_topico.id = $id
                                                "));

        switch ($evento['tipo_id']) {
            case '1':
                $capturados = Capturados::fetchArray("SELECT amc_per_capturadas.nombre as nombre, amc_sexo.desc as sexo, amc_per_capturadas.edad, amc_nacionalidad.desc as nacionalidad, amc_delito.desc as delito FROM amc_per_capturadas 
                                                                    inner join amc_nacionalidad on amc_per_capturadas.nacionalidad = amc_nacionalidad.id 
                                                                    inner join amc_sexo on amc_per_capturadas.sexo = amc_sexo.id 
                                                                    inner join amc_delito on amc_per_capturadas.delito = amc_delito.id 
                                                                    where topico = $id
                ");
                $detalle = $router->load('reportes/captura', [
                    'capturados' => $capturados,
                ]);
                break;
                case '2':
                $asesinados = Capturados::fetchArray("SELECT nombre, edad, desc as sexo from amc_per_asesinadas inner join amc_sexo on amc_per_asesinadas.sexo = amc_sexo.id where topico = 264
                ");
                $detalle = $router->load('reportes/asesinato', [
                    'asesinados' => $asesinados,
                ]);
                break;

                case '9':
                    // $migrantes = Migrante::fetchArray()
                    // $detalle = $evento['tipo_id'];
                break;
            
            default:
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