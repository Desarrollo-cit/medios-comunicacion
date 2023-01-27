<?php

namespace Controllers;

use Model\Evento;
use MVC\Router;
use Sabberworm\CSS\Value\Size;

class EventoController {
    public static function index(Router $router){
        $topicos = Evento::fetchArray("SELECT * from amc_tipo_topics where situacion = 1");
        $departamentos = Evento::fetchArray("SELECT dm_codigo,dm_desc_lg FROM dep_mun WHERE dm_codigo BETWEEN 0100 AND 2200 AND substr(dm_codigo,3,4)=00 ORDER BY dm_desc_lg");
        $actividades = Evento::fetchArray("SELECT * from amc_actividad_vinculada where situacion = 1");
        $router->render('eventos/index', [
            'topicos' => $topicos,
            'departamentos' => $departamentos,
            'actividades' => $actividades,
        ]);
    }

    public static function municipios(){
        try {
            $departamento = substr($_GET['departamento'], 0,2);
            $municipios = Evento::fetchArray("SELECT dm_codigo as codigo, trim(dm_desc_lg) as descripcion from depmun WHERE dm_codigo[1,2] = $departamento AND dm_codigo[3,4] > 00");
            echo json_encode($municipios);
        } catch (Exception $e) {
            echo json_encode([
                "detalle" => $e->getMessage(),       
                "mensaje" => "Ocurrió  un error en base de datos.",

                "codigo" => 4,
            ]);
        }
    }

    public static function guardar(){
        $_POST['fecha'] = str_replace('T', ' ', $_POST['fecha']);
        $_POST['lugar'] = strtoupper($_POST['lugar']);

        try {
            $evento = new Evento($_POST);
            $resultado = $evento->guardar();


            if($resultado['resultado'] == 1){
                echo json_encode([
                    "mensaje" => "El registro se guardó.",
                    "codigo" => 1,
                ]);
                
            }else{
                echo json_encode([
                    "mensaje" => "Ocurrió  un error.",
                    "codigo" => 0,
                ]);
    
            }
        } catch (Exception $e) {
            echo json_encode([
                "detalle" => $e->getMessage(),       
                "mensaje" => "Ocurrió  un error en base de datos.",

                "codigo" => 4,
            ]);
        }
    }

    public static function eventos(){
        try {
            $topicos = $_GET['topicos'];


            $eventos = null;
            if(strlen($topicos) > 0){
                
                $sql = "SELECT amc_topico.latitud as latitud, amc_topico.longitud as longitud, amc_actividad_vinculada.desc as actividad, amc_tipo_topics.desc as tipo, amc_tipo_topics.id as tipo_id  from amc_topico inner join amc_actividad_vinculada on amc_topico.actividad = amc_actividad_vinculada.id inner join amc_tipo_topics on amc_topico.tipo = amc_tipo_topics.id where amc_topico.situacion = 1 and amc_tipo_topics.id in ($topicos)" ; 
                $eventos = Evento::fetchArray($sql);
            }
            
            echo json_encode($eventos);
        } catch (Exception $e) {
            echo json_encode([
                "detalle" => $e->getMessage(),       
                "mensaje" => "Ocurrió  un error en base de datos.",

                "codigo" => 4,
            ]);
        }
      
    }

}