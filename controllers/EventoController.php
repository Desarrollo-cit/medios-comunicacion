<?php

namespace Controllers;

use Model\Delitos;
use Model\Droga;
use Model\Evento;
use Model\Nacionalidad;
use MVC\Router;
// use PDOException;
use Exception;
use Model\Fuentes;

class EventoController
{
    public static function index(Router $router)
    {
        $topicos = Evento::fetchArray("SELECT * from amc_tipo_topics where situacion = 1");
        $departamentos = Evento::fetchArray("SELECT dm_codigo,dm_desc_lg FROM dep_mun WHERE dm_codigo BETWEEN 0100 AND 2200 AND substr(dm_codigo,3,4)=00 ORDER BY dm_desc_lg");
        $actividades = Evento::fetchArray("SELECT * from amc_actividad_vinculada where situacion = 1");
        $tipos_desastres = Evento::fetchArray("SELECT * from amc_tipo_desastre_natural where situacion = 1");
        $fenomenos = Evento::fetchArray("SELECT * from amc_fenomeno_natural where situacion = 1");
        $tipo_movimiento = Evento::fetchArray("SELECT * from amc_tipo_movimiento_social where situacion = 1");
        $movimiento = Evento::fetchArray("SELECT * from amc_organizacion_mov_social where situacion = 1");
        $drogas = Evento::fetchArray("SELECT * FROM amc_drogas where situacion = 1 ");
        $transportes = Evento::fetchArray("SELECT * FROM amc_transporte where situacion = 1 ");
        $fuentes = Fuentes::where('situacion','1');
        $usuarios = Evento::fetchArray("SELECT * FROM amc_usuarios where situacion = 1");
        if($_SESSION['AMC_ADMIN']){ 
            $dependencia = Evento::fetchArray("SELECT dep_llave,dep_desc_lg,dep_desc_md FROM mper, morg, mdep WHERE per_plaza=org_plaza AND org_dependencia=dep_llave AND per_situacion in ('11','TH','T0') GROUP BY dep_llave,dep_desc_lg,dep_desc_md Order by dep_desc_md");
        }elseif($_SESSION['AMC_COMANDO']){
            $dependencia = Evento::fetchArray("SELECT * FROM MPER FULL OUTER JOIN morg ON per_plaza = org_plaza FULL OUTER JOIN mdep ON dep_llave = org_dependencia WHERE per_catalogo = user");    
        }
        $router->render('eventos/index', [
            'topicos' => $topicos,
            'departamentos' => $departamentos,
            'actividades' => $actividades,
            'tipos_desastres' => $tipos_desastres,
            'fenomenos' => $fenomenos,
            'tipo_movimiento' => $tipo_movimiento,
            'movimiento' => $movimiento,
            'drogas' => $drogas,
            'transportes' => $transportes,
            'dependencia' => $dependencia,
            'fuentes' => $fuentes,
            'usuarios' => $usuarios,
        ]);
    }

    public static function municipios()
    {
        getHeadersApi();
        try {
            $departamento = substr($_GET['departamento'], 0, 2);
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

    public static function sexos()
    {
        getHeadersApi();
        try {

            $sexos = Evento::fetchArray("SELECT * from amc_sexo where situacion = 1");
            echo json_encode($sexos);
        } catch (Exception $e) {
            echo json_encode([
                "detalle" => $e->getMessage(),
                "mensaje" => "Ocurrió  un error en base de datos.",

                "codigo" => 4,
            ]);
        }
    }

    public static function guardar()
    {
        getHeadersApi();
        $_POST['fecha'] = str_replace('T', ' ', $_POST['fecha']);

        try {



            $evento = new Evento($_POST);
            $dependencia = Evento::fetchArray("SELECT org_dependencia from mper inner join morg on per_plaza = org_plaza where per_catalogo = user")[0]['org_dependencia'];
            $evento->dependencia = $dependencia;
            $resultado = $evento->guardar();


            if ($resultado['resultado'] == 1) {
                echo json_encode([
                    "mensaje" => "El registro se guardó.",
                    "id" => $resultado['id'],
                    "codigo" => 1,
                ]);
            } else {
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

    public static function eventos()
    {
        getHeadersApi();
        try {
            $topicos = $_GET['topicos'];
            $arrayTopicos = explode(',',$topicos);
            $fenomeno = $_GET['fenomeno'];
            $inicio = str_replace('T',' ',$_GET['inicio']);
            $fin = str_replace('T',' ',$_GET['fin']);
            $dependencia = $_GET['dependencia'];


            $eventos = null;
            if(strlen($topicos) > 0){
                
                $sql = "SELECT amc_topico.latitud as latitud, amc_topico.longitud as longitud, amc_actividad_vinculada.desc as actividad, amc_tipo_topics.desc as tipo, amc_tipo_topics.id as tipo_id, amc_topico.id as id , trim(dep_desc_ct) as dependencia from amc_topico inner join amc_actividad_vinculada on amc_topico.actividad = amc_actividad_vinculada.id inner join amc_tipo_topics on amc_topico.tipo = amc_tipo_topics.id inner join mdep on amc_topico.dependencia = dep_llave left join amc_desastre_natural on amc_desastre_natural.topico = amc_topico.id where amc_topico.situacion = 1 and amc_tipo_topics.id in ($topicos) " ; 
                
                if($inicio != ''){
                    $sql .= " and amc_topico.fecha >= '$inicio'";
                }
                if($fin != ''){
                    $sql .= " and amc_topico.fecha <= '$fin'";
                }
                if($dependencia != ''){
                    $sql .= " and amc_topico.dependencia = '$dependencia'";
                }else if($_SESSION['AMC_ADMIN']){
                    $sql .= " and amc_topico.dependencia = (SELECT org_dependencia from mper inner join morg on per_plaza = org_plaza where per_catalogo = user) ";
                }else if($_SESSION['AMC_COMANDO']){
                    $sql .= " and amc_topico.dependencia = (SELECT org_dependencia from mper inner join morg on per_plaza = org_plaza where per_catalogo = user) ";


            $arrayTopicos = explode(',', $topicos);
            // $busqueda = array_search('11',$arrayTopicos);
            // echo json_encode($arrayTopicos);
            // exit;


            $eventos = [];
            $data = [];

            if (count($arrayTopicos) > 0) {
                
                $posicion = array_search('11', $arrayTopicos);
                $maras = [];

                if (is_int($posicion)) {

                    $sqlMaras = "SELECT amc_topico.latitud as latitud, amc_topico.longitud as longitud, amc_actividad_vinculada.desc as actividad, amc_tipo_topics.desc as tipo, amc_tipo_topics.id as tipo_id, amc_topico.id as id , trim(dep_desc_ct) as dependencia from amc_topico inner join amc_actividad_vinculada on amc_topico.actividad = amc_actividad_vinculada.id inner join amc_tipo_topics on amc_topico.tipo = amc_tipo_topics.id inner join mdep on amc_topico.dependencia = dep_llave where amc_topico.situacion = 1 and amc_topico.actividad in ('5', '1')";

                    if ($inicio != '') {
                        $sqlMaras .= " and amc_topico.fecha >= '$inicio'";
                    }
                    if ($fin != '') {
                        $sqlMaras .= " and amc_topico.fecha <= '$fin'";
                    }

                    $maras = Evento::fetchArray($sqlMaras);
                    unset($arrayTopicos[$posicion]);
                }  
          
                if (count($arrayTopicos) > 0) {

                    $sql = "SELECT amc_topico.latitud as latitud, amc_topico.longitud as longitud, amc_actividad_vinculada.desc as actividad, amc_tipo_topics.desc as tipo, amc_tipo_topics.id as tipo_id, amc_topico.id as id , trim(dep_desc_ct) as dependencia from amc_topico inner join amc_actividad_vinculada on amc_topico.actividad = amc_actividad_vinculada.id inner join amc_tipo_topics on amc_topico.tipo = amc_tipo_topics.id inner join mdep on amc_topico.dependencia = dep_llave where amc_topico.situacion = 1 and amc_tipo_topics.id in ($topicos) ";

                    if ($inicio != '') {
                        $sql .= " and amc_topico.fecha >= '$inicio'";
                    }
                    if ($fin != '') {
                        $sql .= " and amc_topico.fecha <= '$fin'";
                    }

                    if ($_SESSION['AMC_COMANDO']) {
                        $sql .= " and amc_topico.dependencia = (SELECT org_dependencia from mper inner join morg on per_plaza = org_plaza where per_catalogo = user) ";
                    }
                    $eventos = Evento::fetchArray($sql);

                }

                if( is_int(array_search(7,$arrayTopicos)) && $fenomeno != ''){
                    $sql .= " and amc_desastre_natural.nombre_desastre = $fenomeno ";
                }
                

                
                $data = array_merge($maras, $eventos);


            }

            echo json_encode($data);
        } catch (Exception $e) {
            echo json_encode([
                "detalle" => $e->getMessage(),
                "mensaje" => "Ocurrió  un error en base de datos.",

                "codigo" => 4,
            ]);
        }
    }


    public static function getEventoIdApi(){
        getHeadersApi();
        try {
            $id = $_GET['id'];
            $sql = "SELECT amc_topico.latitud as latitud, amc_topico.longitud as longitud, amc_actividad_vinculada.desc as actividad, amc_tipo_topics.desc as tipo, amc_tipo_topics.id as tipo_id, amc_topico.id as id , trim(dep_desc_ct) as dependencia from amc_topico inner join amc_actividad_vinculada on amc_topico.actividad = amc_actividad_vinculada.id inner join amc_tipo_topics on amc_topico.tipo = amc_tipo_topics.id inner join mdep on amc_topico.dependencia = dep_llave where amc_topico.situacion = 1 and amc_topico.id = $id ";
            $eventos = array_shift(Evento::fetchArray($sql));
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

