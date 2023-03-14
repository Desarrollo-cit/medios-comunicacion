<?php

namespace Controllers;

use Classes\Reporte;
use Exception;
use Model\Armas;
use Model\Capturados;
use Model\Desastre_natural;
use Model\Evento;
use Model\Incautacion;
use Model\IncautacionArmas;
use Model\IncautacionMunicion;
use Mpdf\Mpdf;
use MVC\Router;

class ReporteController{

    public static function reporteTopico(Router $router){
        $id = $_GET['id'];
        hasPermission(['AMC_ADMIN', 'AMC_COMANDO']);
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
        $detalle = $evento['tipo_id'];
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
                $asesinados = Capturados::fetchArray("SELECT nombre, edad, desc as sexo from amc_per_asesinadas inner join amc_sexo on amc_per_asesinadas.sexo = amc_sexo.id where topico = $id
                ");
                $detalle = $router->load('reportes/asesinato', [
                    'asesinados' => $asesinados,
                ]);
                break;
                case '4':
                $detalle = Incautacion::fetchArray("SELECT tipos1.desc as tipo, tipos2.desc as tipo_plantacion, amc_transporte.desc as transporte, amc_incautacion_droga.matricula, amc_incautacion_droga.tipo_transporte, amc_incautacion_droga.cantidad , amc_incautacion_droga.cantidad_plantacion from amc_incautacion_droga inner join amc_drogas tipos1 on tipos1.id = amc_incautacion_droga.tipo_droga inner join amc_drogas tipos2 on tipos2.id = amc_incautacion_droga.tip_droga_plantacion inner join amc_transporte on amc_incautacion_droga.transporte = amc_transporte.id where topico = $id");
                $capturados = Capturados::fetchArray("SELECT amc_per_capturadas.nombre as nombre, amc_sexo.desc as sexo, amc_per_capturadas.edad, amc_nacionalidad.desc as nacionalidad, amc_delito.desc as delito FROM amc_per_capturadas 
                                inner join amc_nacionalidad on amc_per_capturadas.nacionalidad = amc_nacionalidad.id 
                                inner join amc_sexo on amc_per_capturadas.sexo = amc_sexo.id 
                                inner join amc_delito on amc_per_capturadas.delito = amc_delito.id 
                                where topico = $id
                ");
                $detalle = $router->load('reportes/drogas', [
                    'detalle' => $detalle,
                    'capturados' => $capturados,
                ]);
                break;
                case '5':
                $detalle = Incautacion::fetchArray("SELECT amc_incautacion_dinero.cantidad, amc_incautacion_dinero.conversion, amc_moneda.desc as moneda  from amc_incautacion_dinero inner join amc_moneda on moneda = amc_moneda.id where topico = $id");
                $detalle = $router->load('reportes/dinero', [
                    'detalle' => $detalle,
                ]);
                break;
                case '6':
                $armas = IncautacionArmas::fetchArray("SELECT amc_detalle_arma.cantidad, amc_tipo_armas.desc as tipo, amc_calibre.desc as calibre from amc_detalle_arma inner join amc_tipo_armas on amc_detalle_arma.tipo_arma = amc_tipo_armas.id inner join amc_calibre on amc_detalle_arma.calibre = amc_calibre.id where topico = $id");
                $municiones = IncautacionMunicion::fetchArray(" select amc_detalle_municion.cantidad, amc_calibre.desc as calibre from amc_detalle_municion inner join amc_calibre on amc_detalle_municion.calibre = amc_calibre.id where topico = $id");
                $detalle = $router->load('reportes/armamento', [
                    'armas' => $armas,
                    'municiones' => $municiones,
                ]);
                break;
                case '7':
                $desastres = Desastre_natural::fetchArray("SELECT amc_desastre_natural.* , amc_tipo_desastre_natural.desc as tipo_desastre , amc_fenomeno_natural.desc as fenomeno from amc_desastre_natural inner join amc_tipo_desastre_natural on amc_desastre_natural.tipo = amc_tipo_desastre_natural.id inner join amc_fenomeno_natural on amc_desastre_natural.nombre_desastre = amc_fenomeno_natural.id where topico = $id");
                $detalle = $router->load('reportes/desastres', [
                    'desastres' => $desastres,
                ]);
                break;
                case '8':
                $pistas = Desastre_natural::fetchArray("select * from amc_destruccion_pista where topico = $id");
                $detalle = $router->load('reportes/pistas', [
                    'pistas' => $pistas,
                ]);
                break;

                case '9':
                    $migrantes = Capturados::fetchArray("SELECT amc_migrantes.cantidad, amc_edades.edades as edad, amc_sexo.desc as sexo , amc_migrantes.lugar_ingreso, paises.pai_desc_lg as destino, amc_nacionalidad.desc procedencia from amc_migrantes inner join amc_edades on amc_migrantes.edad = amc_edades.id inner join amc_sexo on amc_migrantes.sexo = amc_sexo.id inner join paises on amc_migrantes.destino = paises.pai_codigo inner join amc_nacionalidad on amc_migrantes.pais_migrante = amc_nacionalidad.id where amc_migrantes.topic = $id");
                    $detalle = $router->load('reportes/migrantes', [
                        'migrantes' => $migrantes,
                    ]);
                break;
            
                case '10':
                    $movimientos = Capturados::fetchArray("select amc_movimiento_social.cantidad, amc_tipo_movimiento_social.desc as tipo , amc_organizacion_mov_social.desc as organizacion from amc_movimiento_social inner join amc_tipo_movimiento_social on tipo_movimiento = amc_tipo_movimiento_social.id inner join amc_organizacion_mov_social on organizacion = amc_organizacion_mov_social.id where topico = $id");
                    $detalle = $router->load('reportes/movimientos', [
                        'movimientos' => $movimientos,
                    ]);
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

    public static function reporteGeneral(Router $router){
        hasPermission(['AMC_ADMIN', 'AMC_COMANDO']);
        
        $inicio = str_replace('T',' ', $_GET['inicio']);
        $fin = str_replace('T',' ', $_GET['fin']);
        
        try{
            $user = $_SESSION['auth_user'];

            $userInfo = array_shift(Evento::fetchArray("SELECT * from mper inner join morg on per_plaza = org_plaza inner join mdep on org_dependencia = dep_llave where per_catalogo = $user "));
            $reporte = new Reporte($router, $userInfo);
            $pdf = $reporte->generatePDF();

            $sql = "SELECT amc_topico.tipo as tipo_id, amc_topico.info ,amc_topico.fecha as fecha, amc_topico.lugar as lugar, amc_topico.latitud, amc_topico.longitud, amc_tipo_topics.desc as tipo, amc_actividad_vinculada.desc as actividad, dm_mun_dep as municipio
            FROM amc_topico 
            inner join amc_tipo_topics on amc_topico.tipo = amc_tipo_topics.id 
            inner join depmun on municipio = dm_codigo 
            inner join amc_actividad_vinculada on amc_topico.actividad = amc_actividad_vinculada.id where amc_topico.situacion = 1 ";

            if($inicio != ''){
                $sql .= " AND amc_topico.fecha >= '$inicio' ";
            }
            if($fin != ''){
                $sql .= " AND amc_topico.fecha <= '$fin' ";
            }

            $sql .= " ORDER BY amc_topico.fecha asc ";
            $eventos = Evento::fetchArray($sql);

            $contenido = $router->load('reportes/general', [
                'eventos' => $eventos,
                'inicio' =>  $inicio,
                'fin' => $fin,
            ]);


            $pdf->WriteHTML($contenido);
            


            $pdf->Output();
        } catch (Exception $e) {
            echo json_encode([
                "detalle" => $e->getMessage(),       
                "mensaje" => "Ocurrió  un error en base de datos.",

                "codigo" => 4,
            ]);
        }
    }
}