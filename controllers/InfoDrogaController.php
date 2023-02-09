<?php

namespace Controllers;

use Exception;
use DateTime;
use Model\Droga;
use Model\Delito;
use Model\DepMun;
// use Model\Delito;
use MVC\Router;

class InfoDrogaController
{
    public function index(Router $router)
    {
        $drogas_tipo = static::drogas_tipo();
        $operacionesDroga = static::operacionesDroga();
        $total_droga = static::total_droga();
        $incidenciaDroga = static::incidenciaDroga();
        $totalMatas = static::totalMatas();
        $incidenciaMatas = static::incidenciaMatas();
        $captura = static::captura();
        $hombres = static::hombres();
        $mujer = static::mujer();
        $pista = static::pista();
        $departamentoCapturas = static::departamentoCapturas();
        $departamentoPistas = static::departamentoPistas();
        $colores = static::coloresAPI1();

        $router->render('mapas/droga', [
            'drogas_tipo' => $drogas_tipo,
            'operacionesDroga' => $operacionesDroga,
            'total_droga' => $total_droga,
            'incidenciaDroga' => $incidenciaDroga,
            'totalMatas' => $totalMatas,
            'incidenciaMatas' => $incidenciaMatas,
            'captura' => $captura,
            'hombres' => $hombres,
            'mujer' => $mujer,
            'pista' => $pista,
            'departamentoCapturas' => $departamentoCapturas,
            'departamentoPistas' => $departamentoPistas,
            'colores' => $colores,

        ]);
    }

    static function  drogas_tipo()
    {

        $sentencia = "SELECT * from amc_drogas where situacion = 1";
        $result = Droga::fetchArray($sentencia);
        return $result;
    }

    static public function coloresAPI()
    {
        getHeadersApi();
        try {
            $sql = "SELECT * from amc_colores where topico = 1 and situacion = 1 order by nivel asc ";
            $info = Droga::fetchArray($sql);
            echo json_encode($info);
        } catch (Exception $e) {
            return [];
        }
    }

    static public function coloresAPI1()
    {

        try {
            $sql = "SELECT * from amc_colores where topico = 4  ";
            $info = Droga::fetchArray($sql);
            return $info;
        } catch (Exception $e) {
            return [];
        }
    }
    protected static function operacionesDroga($fecha1 = "", $fecha2 = "")
    {


        $sql = "SELECT  count (*) as cantidad from amc_incautacion_droga inner join amc_topico on amc_incautacion_droga.topico = amc_topico.id  where  amc_topico.situacion = 1 and amc_incautacion_droga.situacion = 1";

        if ($fecha1 != '' && $fecha2 != '') {

            $sql .= " AND amc_topico.fecha   BETWEEN '$fecha1' AND  '$fecha2' ";
        } else {

            $sql .= " AND year(amc_topico.fecha) = year(current)  and  month(amc_topico.fecha) = month(current) ";
        }
        $result = Droga::fetchArray($sql);
        if ($result) {
            return $result;
        } else {

            $capturas = [[
                "cantidad" =>
                "Sin datos"
            ]];
            return $capturas;
        }
    }


    static function total_droga($fecha1 = "", $fecha2 = "", $depto = "", $droga = "")
    {


        $sql = "SELECT sum(cantidad) as cantidad from amc_incautacion_droga inner join amc_topico on amc_incautacion_droga.topico = amc_topico.id  where   amc_topico.situacion = 1 and amc_incautacion_droga.situacion = 1";

        if ($fecha1 == '' && $fecha2 == '') {

            $sql .= " AND year(amc_topico.fecha) = year(current) and month(amc_topico.fecha) = month(current) ";
        }

        if ($droga != '') {

            $sql .= " AND amc_incautacion_droga.tipo_droga = $droga";
        }
        if ($depto != '') {

            $sql .= " AND amc_topico.departamento = $depto";
        }

        if ($fecha1 != '' && $fecha2 != '') {

            $sql .= " AND amc_topico.fecha   BETWEEN '$fecha1' AND  '$fecha2' ";
        }
        $result = Droga::fetchArray($sql);
        if ($result[0]['cantidad'] != null) {
            return $result;
        } else {

            $result = [[
                "cantidad" =>
                "0"
            ]];
            return $result;
        }
    }


    static function incidenciaDroga($fecha1 = "", $fecha2 = "", $depto = "", $droga = "")
    {


        $sql = "   SELECT FIRST 1  amc_drogas.desc, sum(cantidad) as cantidad from amc_incautacion_droga inner join amc_drogas on amc_incautacion_droga.tipo_droga = amc_drogas.id inner join amc_topico on amc_incautacion_droga.topico = amc_topico.id  where  amc_incautacion_droga.situacion = 1  ";

        if ($fecha1 == '' && $fecha2 == '') {

            $sql .= " AND  year(amc_topico.fecha) = year(current) and month(amc_topico.fecha) = month(current) ";
        }

        if ($droga != '') {

            $sql .= " AND amc_incautacion_droga.tipo_droga = $droga";
        }
        if ($depto != '') {

            $sql .= " AND amc_topico.departamento = $depto";
        }

        if ($fecha1 != '' && $fecha2 != '') {

            $sql .= " AND amc_topico.fecha   BETWEEN '$fecha1' AND  '$fecha2' ";
        }

        $sql .= " group by  desc order by desc asc";
        $result = Droga::fetchArray($sql);
        if ($result) {
            return $result;
        } else {



            $result = [[
                "desc" =>
                "Sin datos"
            ]];
            return $result;
        }
    }

    static function totalMatas($fecha1 = "", $fecha2 = "",  $depto = "", $droga = "")
    {


        $sql = "SELECT sum(cantidad_plantacion) as cantidad from amc_incautacion_droga inner join amc_topico on amc_incautacion_droga.topico = amc_topico.id  where   amc_topico.situacion = 1 and amc_incautacion_droga.situacion = 1";

        if ($fecha1 == '' && $fecha2 == '') {

            $sql .= " AND year(amc_topico.fecha) = year(current) and month(amc_topico.fecha) = month(current) ";
        }

        if ($droga != '') {

            $sql .= " AND amc_incautacion_droga.tip_droga_plantacion = $droga";
        }
        if ($depto != '') {

            $sql .= " AND amc_topico.departamento = $depto";
        }

        if ($fecha1 != '' && $fecha2 != '') {

            $sql .= " AND amc_topico.fecha   BETWEEN '$fecha1' AND  '$fecha2' ";
        }
        $result = Droga::fetchArray($sql);
        if ($result[0]['cantidad'] != null) {
            return $result;
        } else {

            $result = [[
                "cantidad" =>
                "0"
            ]];
            return $result;
        }
    }

    static function incidenciaMatas($fecha1 = "", $fecha2 = "", $depto = "", $droga = "")
    {


        $sql = "   SELECT FIRST 1  amc_drogas.desc, sum(cantidad_plantacion) as cantidad from amc_incautacion_droga inner join amc_drogas on amc_incautacion_droga.tip_droga_plantacion = amc_drogas.id inner join amc_topico on amc_incautacion_droga.topico = amc_topico.id  where   amc_incautacion_droga.situacion = 1  ";

        if ($fecha1 == '' && $fecha2 == '') {

            $sql .= " AND year(amc_topico.fecha) = year(current) and month(amc_topico.fecha) = month(current) ";
        }

        if ($droga != '') {

            $sql .= " AND amc_incautacion_droga.tip_droga_plantacion = $droga";
        }
        if ($depto != '') {

            $sql .= " AND amc_topico.departamento = $depto";
        }

        if ($fecha1 != '' && $fecha2 != '') {

            $sql .= " AND amc_topico.fecha   BETWEEN '$fecha1' AND  '$fecha2' ";
        }
        $sql .= " group by  desc order by desc asc";
        $result = Droga::fetchArray($sql);
        if ($result) {


            return $result;
        } else {

            $result = [[
                "desc" =>
                "Sin datos"
            ]];
            return $result;
        }
    }

    static function captura($fecha1 = "", $fecha2 = "")
    {


        $sql = "SELECT  count (*) as cantidad from amc_per_capturadas inner join amc_topico on amc_per_capturadas.topico = amc_topico.id  where amc_topico.tipo in (1,4) and amc_per_capturadas.delito = 1 and amc_topico.situacion = 1 and amc_per_capturadas.situacion = 1 ";

        if ($fecha1 == '' && $fecha2 == '') {

            $sql .= " AND year(amc_topico.fecha) = year(current) and month(amc_topico.fecha) = month(current) ";
        }
        if ($fecha1 != '' && $fecha2 != '') {
            $sql .= " AND amc_topico.fecha   BETWEEN '$fecha1' AND  '$fecha2' ";
        }
        $result = Droga::fetchArray($sql);
        if ($result) {
            return $result;
        } else {

            $delito = [[
                "cantidad" =>
                "Sin datos"
            ]];
            return $delito;
        }
    }

    static function hombres($fecha1 = "", $fecha2 = "")
    {
        $sql = "SELECT count(*) as cantidad from amc_per_capturadas inner join amc_topico on amc_per_capturadas.topico = amc_topico.id   where amc_per_capturadas.delito = 1 and  amc_topico.situacion = 1 and amc_per_capturadas.sexo = 1 and amc_per_capturadas.situacion = 1";

        if ($fecha1 == '' && $fecha2 == '') {

            $sql .= " AND year(amc_topico.fecha) = year(current) and month(amc_topico.fecha) = month(current) ";
        }
        if ($fecha1 != '' && $fecha2 != '') {
            $sql .= " AND amc_topico.fecha   BETWEEN '$fecha1' AND  '$fecha2' ";
        }
        $result = Droga::fetchArray($sql);
        if ($result) {
            return $result;
        } else {

            $delito = array("cantidad" => "Sin datos");
            return $delito;
        }
    }

    static function mujer($fecha1 = "", $fecha2 = "")
    {


        $sql = "SELECT  count(*) as cantidad from amc_per_capturadas inner join amc_topico on amc_per_capturadas.topico = amc_topico.id   where  amc_per_capturadas.delito = 1 and  amc_topico.situacion = 1 and amc_per_capturadas.sexo = 2 and amc_per_capturadas.situacion = 1";


        if ($fecha1 == '' && $fecha2 == '') {

            $sql .= " AND year(amc_topico.fecha) = year(current) and month(amc_topico.fecha) = month(current) ";
        }
        if ($fecha1 != '' && $fecha2 != '') {
            $sql .= " AND amc_topico.fecha   BETWEEN '$fecha1' AND  '$fecha2' ";
        }
        $result = Droga::fetchArray($sql);
        if ($result) {
            return $result;
        } else {

            $delito = array("cantidad" => "Sin datos");
            return $delito;
        }
    }

    static   function pista($fecha1 = "", $fecha2 = "", $depto = "")
    {


        $sql = "SELECT  count (*) as cantidad from amc_destruccion_pista inner join amc_topico on amc_destruccion_pista.topico = amc_topico.id  where   amc_topico.situacion = 1 and amc_destruccion_pista.situacion = 1";

        if ($fecha1 == '' && $fecha2 == '') {

            $sql .= " AND year(amc_topico.fecha) = year(current) and month(amc_topico.fecha) = month(current) ";
        }
        if ($fecha1 != '' && $fecha2 != '') {

            $sql .= " AND amc_topico.fecha   BETWEEN '$fecha1' AND  '$fecha2' ";
        }
        if ($depto != '') {

            $sql .= " AND amc_topico.departamento = $depto";
        }


        $result = Droga::fetchArray($sql);
        if ($result) {
            return $result;
        } else {

            $result = [[
                "cantidad" =>
                "Sin datos"
            ]];
            return $result;
        }
    }

    static   function departamentoCapturas($fecha1 = "", $fecha2 = "")
    {
        $sql = "SELECT FIRST 1 amc_topico.departamento as departamento, count(*) as cantidad FROM amc_topico inner join amc_incautacion_droga on amc_topico.id = amc_incautacion_droga.topico where amc_topico.tipo = 4 and amc_topico.situacion = 1 ";
        if ($fecha1 == '' && $fecha2 == '') {

            $sql .= " AND year(amc_topico.fecha) = year(current) and month(amc_topico.fecha) = month(current) ";
        }
        if ($fecha1 != '' && $fecha2 != '') {

            $sql .= " AND amc_topico.fecha   BETWEEN '$fecha1' AND  '$fecha2' ";
        }


        $sql .= "group by departamento order by cantidad desc";



        $result = Droga::fetchArray($sql);

        if ($result) {
            foreach ($result as $row) {

                $depto = $row['departamento'];
            }

            $sql = "SELECT dm_desc_lg as desc from depmun where dm_codigo = $depto ";
            $result1 = Droga::fetchArray($sql);
            return $result1;
        } else {

            $delito = [[
                'desc' => "Sin datos"
            ]];
            return $delito;
        }
    }

    static function departamentoPistas($fecha1 = "", $fecha2 = "")
    {
        $sql = "SELECT FIRST 1 amc_topico.departamento as departamento, count(*) as cantidad FROM amc_topico inner join amc_destruccion_pista on amc_topico.id = amc_destruccion_pista.topico where  amc_topico.tipo = 8 and amc_topico.situacion = 1 ";
        if ($fecha1 == '' && $fecha2 == '') {

            $sql .= " AND year(amc_topico.fecha) = year(current) and month(amc_topico.fecha) = month(current) ";
        }
        if ($fecha1 != '' && $fecha2 != '') {

            $sql .= " AND amc_topico.fecha   BETWEEN '$fecha1' AND  '$fecha2' ";
        }


        $sql .= "group by departamento order by cantidad desc";



        $result1 = Droga::fetchArray($sql);

        if ($result1) {
            foreach ($result1 as $row) {

                $depto = $row['departamento'];
            }

            $sql = "SELECT dm_desc_lg as desc from depmun where dm_codigo = $depto ";
            $result1 = Droga::fetchArray($sql);
            return $result1;
        } else {

            $delito = [[
                'desc' => "Sin datos"
            ]];
            return $delito;
        }
    }

    public function resumenAPI()
    {
        // getHeadersApi();
        // echo json_encode($_POST) ;


        $fecha1 = $_POST['fecha_resumen'];
        $fecha2 = $_POST['fecha_resumen2'];

        $fecha1 = str_replace('T', ' ', $fecha1);
        $fecha2 = str_replace('T', ' ', $fecha2);



        $operacionesDroga = static::operacionesDroga($fecha1, $fecha2);
        $total_droga = static::total_droga($fecha1, $fecha2);
        $incidenciaDroga = static::incidenciaDroga($fecha1, $fecha2);
        $incidenciaMatas = static::incidenciaMatas($fecha1, $fecha2);
        $totalMatas = static::totalMatas($fecha1, $fecha2);
        $captura = static::captura($fecha1, $fecha2);
        $mujer = static::mujer($fecha1, $fecha2);
        $hombres = static::hombres($fecha1, $fecha2);
        $pista = static::pista($fecha1, $fecha2);
        $departamentoCapturas = static::departamentoCapturas($fecha1, $fecha2);
        $departamentoPistas = static::departamentoPistas($fecha1, $fecha2);
        $array_resultante = array_merge($operacionesDroga, $incidenciaDroga, $total_droga, $incidenciaMatas, $totalMatas, $captura, $mujer, $hombres, $pista, $departamentoCapturas, $departamentoPistas);

        echo json_encode($array_resultante);
    }

    public function listadoAPI()
    {
        getHeadersApi();


        try {

            $sql = "SELECT DISTINCT  amc_topico.id as id, amc_topico.lugar as lugar, amc_topico.tipo as tipo, amc_tipo_topics.desc as topico,  amc_topico.fecha as fecha, dm_desc_lg as departamento,   amc_actividad_vinculada.desc as actividad from amc_topico inner join amc_tipo_topics on amc_topico.tipo = amc_tipo_topics.id inner join depmun on amc_topico.departamento = depmun.dm_codigo  inner join amc_actividad_vinculada on amc_topico.actividad = amc_actividad_vinculada.id and amc_topico.tipo in(4,8) and amc_topico.situacion = 1";
            $info = Droga::fetchArray($sql);

            $data = [];

            $i = 1;
            foreach ($info as $key) {
                $id = $key['id'];
                $lugar = $key['lugar'];
                $fecha = $key['fecha'];
                $departamento = trim($key['departamento']);
                $topico = $key['topico'];
                $tipo = $key['tipo'];

                $actividad = $key['actividad'];
                //    $destino_id = $key['ALMACEN_DESTINO'];
                //    $id = $key['ALMACEN_ID'];




                $arrayInterno = [[
                    "contador" => $i,
                    "id" => $id,
                    "lugar" => $lugar,
                    "fecha" => $fecha,
                    "departamento" => $departamento,
                    "topico" => $topico,
                    "tipo" => $tipo,
                    "actividad" => $actividad,







                ]];
                $i++;
                $data = array_merge($data, $arrayInterno);
            }

            $arrayreturn = ["data" => $data];
            echo json_encode($data);
        } catch (Exception $e) {
            echo json_encode([
                "detalle" => $e->getMessage(),
                "mensaje" => "ocurrio un error en base de datos",

                "codigo" => 4,
            ]);
        }
    }

    public function modalAPI()
    {
        getHeadersApi();

        // echo json_encode($sql);

        try {

            $id = $_POST['id'];


            $sql = "SELECT amc_topico.id, fecha, lugar, departamento, municipio as muni, tipo,latitud,longitud,actividad, amc_topico.situacion, depmun.dm_desc_lg as departamento1, amc_actividad_vinculada.desc as act, amc_tipo_topics.desc as topico from amc_topico inner join depmun on amc_topico.departamento = depmun.dm_codigo inner join amc_actividad_vinculada on amc_topico.actividad = amc_actividad_vinculada.id inner join amc_tipo_topics on amc_topico.tipo = amc_tipo_topics.id where amc_topico.situacion = 1 and amc_topico.id =  $id";
            $info = Droga::fetchArray($sql);
            $data = [];


            $i = 1;
            foreach ($info as $key) {
                $id = $key['id'];
                $lugar = $key['lugar'];
                $fecha = $key['fecha'];
                $depto = trim($key['departamento1']);
                $depto1 = trim((string)$key['departamento']);
                $muni = $key['muni'];
                $latitud = $key['latitud'];
                $longitud = $key['longitud'];
                $tipo = $key['topico'];
                $delito = $key['delito'];
                $actividad = $key['act'];


                if ($depto1 < 1000) {

                    $depto1 = '0' . $depto1;
                }

                //    $sql1 = "SELECT dm_desc_md as municipio from depmun where dm_codigo = $municipio ";

                $municipio = DepMun::fetchArray("SELECT dm_desc_lg as municipio from depmun where dm_codigo = $muni");
                //    foreach($municipio as $key1){ 
                //     $nombreMuni = $key1['dm_desc_lg'];
                $municipio = $municipio[0]['municipio'];
                // }


                $arrayInterno = [[
                    "contador" => $i,
                    "id" => $id,
                    "lugar" => $lugar,
                    "fecha" => $fecha,
                    "depto" => $depto,
                    "municipio" => $municipio,
                    "topico" => $tipo,
                    "latitud" => $latitud,
                    "longitud" => $longitud,
                    "delito" => $delito,
                    "actividad" => $actividad,

                ]];
                $i++;
                $data = array_merge($data, $arrayInterno);
            }

            echo json_encode($data);
        } catch (Exception $e) {
            echo json_encode([
                "detalle" => $e->getMessage(),
                "mensaje" => "ocurrio un error en base de datos",

                "codigo" => 4,
            ]);
        }
    }

    public function informacionModalAPI()
    {
        getHeadersApi();

        // echo json_encode($sql);

        try {

            $id = $_POST['id'];

            $sql = "SELECT amc_incautacion_droga.cantidad as cantidad,  amc_incautacion_droga.tipo_transporte as tipo_t, amc_incautacion_droga.id, amc_incautacion_droga.tipo_droga, matricula, amc_drogas.desc as droga, amc_transporte.desc as transporte   from amc_incautacion_droga inner join amc_drogas on amc_incautacion_droga.tipo_droga = amc_drogas.id inner join amc_transporte on amc_incautacion_droga.transporte = amc_transporte.id where amc_incautacion_droga.topico =$id and  amc_incautacion_droga.situacion = 1";
            $info = Droga::fetchArray($sql);


            echo json_encode($info);
        } catch (Exception $e) {
            echo json_encode([
                "detalle" => $e->getMessage(),
                "mensaje" => "ocurrio un error en base de datos",

                "codigo" => 4,
            ]);
        }
    }


    public function informacionModalAPI1()
    {
        getHeadersApi();

        // echo json_encode($sql);

        try {

            $id = $_POST['id'];

            $sql = "SELECT amc_drogas.desc as tipo_droga,  amc_incautacion_droga.tip_droga_plantacion as tipo_matas,  amc_incautacion_droga.cantidad_plantacion as cantidad1   from amc_incautacion_droga inner join amc_drogas on amc_incautacion_droga.tip_droga_plantacion = amc_drogas.id  where amc_incautacion_droga.topico =$id and  amc_incautacion_droga.situacion = 1";
            $info = Droga::fetchArray($sql);


            echo json_encode($info);
        } catch (Exception $e) {
            echo json_encode([
                "detalle" => $e->getMessage(),
                "mensaje" => "ocurrio un error en base de datos",

                "codigo" => 4,
            ]);
        }
    }


    public function informacionPersonasAPI()
    {
        getHeadersApi();

        // echo json_encode($sql);

        try {

            $id = $_POST['id'];

            $sql = "SELECT amc_per_capturadas.id, amc_per_capturadas.topico, amc_nacionalidad.desc as nacionalidad, amc_sexo.desc as sexo, amc_per_capturadas.nombre, amc_per_capturadas.edad, amc_delito.desc as delito  from amc_per_capturadas inner join amc_nacionalidad on amc_per_capturadas.nacionalidad = amc_nacionalidad.id inner join amc_sexo on amc_sexo.id = amc_per_capturadas.sexo inner join amc_delito on amc_per_capturadas.delito = amc_delito.id where topico = $id and amc_per_capturadas.situacion = 1";

            $info = Droga::fetchArray($sql);
            $data = [];

            $i = 1;
            if ($info) {
                foreach ($info as $key) {
                    $id = $key['id'];
                    $sexo = $key['sexo'];
                    $nacionalidad = $key['nacionalidad'];
                    $nombre = $key['nombre'];
                    $topico = $key['topico'];
                    $delito = $key['delito'];
                    $edad = $key['edad'];


                    $arrayInterno = [[
                        "contador" => $i,
                        "id" => $id,
                        "sexo" => $sexo,
                        "nacionalidad" => $nacionalidad,
                        "nombre" => $nombre,
                        "topico" => $topico,
                        "delito" => $delito,
                        "edad" => $edad,




                    ]];
                    $i++;
                    $data = array_merge($data, $arrayInterno);
                }
            }


            echo json_encode($data);
        } catch (Exception $e) {
            echo json_encode([
                "detalle" => $e->getMessage(),
                "mensaje" => "ocurrio un error en base de datos",

                "codigo" => 4,
            ]);
        }
    }
    public function distanciaPistaAPI()
    {
        getHeadersApi();

        // echo json_encode($sql);

        try {

            $id = $_POST['id'];

            $sql = "SELECT amc_destruccion_pista.distancia as cantidad from amc_destruccion_pista where amc_destruccion_pista.topico =$id and  amc_destruccion_pista.situacion = 1";
            $info = Droga::fetchArray($sql);


            echo json_encode($info);
        } catch (Exception $e) {
            echo json_encode([
                "detalle" => $e->getMessage(),
                "mensaje" => "ocurrio un error en base de datos",

                "codigo" => 4,
            ]);
        }
    }

    public function mapaCalorAPI()
    {
        getHeadersApi();

        // echo json_encode($sql);

        try {
            $tipo_droga = $_POST['incautaciondroga_mapa_calor'];
            $fecha1 = str_replace('T', ' ', $_POST['fecha_mapa']);
            $fecha2 = str_replace('T', ' ', $_POST['fecha2']);


            $sql = " SELECT distinct dm_desc_lg as descripcion, dm_codigo as codigo, count (*) as cantidad FROM amc_topico inner join depmun on departamento = dm_codigo inner join amc_incautacion_droga on amc_topico.id = amc_incautacion_droga.topico where  amc_topico.situacion = 1 and amc_topico.tipo = 4 ";

            if ($tipo_droga != '') {

                $sql .= "AND amc_incautacion_droga.tipo_droga = $tipo_droga";
            }

            if ($fecha1 != '' && $fecha2 != '') {
                $sql .= " AND amc_topico.fecha   BETWEEN '$fecha1' AND  '$fecha2' ";
            }
            if ($fecha1 == '' && $fecha2 == '') {
                $sql .= " AND year(fecha) = year(current) AND month(fecha) = month(current)";
            }
            $sql .= " group by descripcion, codigo";

            $info = Droga::fetchArray($sql);


            if ($info == null && $tipo_droga != '') {

                $sql = " SELECT distinct dm_desc_lg as descripcion, dm_codigo as codigo, count (*) as cantidad FROM amc_topico inner join depmun on departamento = dm_codigo inner join amc_incautacion_droga on amc_topico.id = amc_incautacion_droga.topico where  amc_topico.situacion = 1 and amc_topico.tipo = 4  ";

                if ($tipo_droga != '') {

                    $sql .= "AND amc_incautacion_droga.tip_droga_plantacion = $tipo_droga";
                }

                if ($fecha1 != '' && $fecha2 != '') {
                    $sql .= " AND amc_topico.fecha   BETWEEN '$fecha1' AND  '$fecha2' ";
                }
                if ($fecha1 == '' && $fecha2 == '') {
                    $sql .= " AND year(fecha) = year(current) AND month(fecha) = month(current)";
                }
                $sql .= " group by descripcion, codigo";

                $info = Droga::fetchArray($sql);
            }
            echo json_encode($info);
        } catch (Exception $e) {
            echo json_encode([
                "detalle" => $e->getMessage(),
                "mensaje" => "ocurrio un error en base de datos",

                "codigo" => 4,
            ]);
        }
    }

    public function mapaCalorDeptoAPI()
    {
        getHeadersApi();
        try {

            $depto = $_POST['departamento'];
            $droga = $_POST['incautaciondroga_mapa_calor'];
            $fecha1 = str_replace('T', ' ', $_POST['fecha_mapa']);
            $fecha2 = str_replace('T', ' ', $_POST['fecha2']);


            $total_droga = static::total_droga($fecha1, $fecha2,  $depto, $droga);
            $incidencia_droga = static::incidenciaDroga($fecha1, $fecha2, $depto, $droga);
            $incidencia_droga1 = static::incidenciaMatas($fecha1, $fecha2, $depto, $droga);
            $total_matas = static::totalMatas($fecha1, $fecha2, $depto, $droga);
            $pista = static::pista($fecha1, $fecha2, $depto);


            $array_resultante = array_merge($total_droga, $incidencia_droga, $total_matas, $incidencia_droga1, $pista);

            echo json_encode($array_resultante);
        } catch (Exception $e) {
            return [];
        }
    }

    function departamental_grafica($mes, $fecha1, $fecha2, $depto, $droga)
    {

        if ($mes == 13) {
            return static::total_droga($fecha1, $fecha2, $depto, $droga);
        }
        if ($mes == 14) {
            return static::totalMatas($fecha1, $fecha2, $depto, $droga);
        }
    }


    public function mapaCalorPorDeptoGraficaAPI()
    {
        try {


            $depto = $_POST['departamento'];
            $droga = $_POST['incautaciondroga_mapa_calor'];
            $fecha1 = str_replace('T', ' ', $_POST['fecha_mapa']);
            $fecha2 = str_replace('T', ' ', $_POST['fecha2']);
            // echo json_encode($_POST);
            // exit;


            $tipos = static::drogas_tipo();

            $data = [];
            $labels = [];
            $drogas = [];
            $cantidades = [];
            $i = 0;
          
           

                for ($i = 13; $i <= 14; $i++) {

                    foreach ($tipos as $key => $tipo) {

                        $droga = (int)$tipo['id'];

                        $labels[] = $tipo['desc'];

                        $operaciones = static::departamental_grafica($i,  $fecha1, $fecha2, $depto, $droga);

                        if ($i == 13) {
                            $dataset = 'KILOS';
                        } else {
                            if ($i == 14) {
                                $dataset = 'MATAS';
                            }
                        }
                       
                      
                        $cantidades[$dataset][] = (int) $operaciones[0]['cantidad'];
                    }
                   
                    
                     
                }
               
               
                foreach ($tipos as $key => $tipo) {

                    $droga = $tipo['id'];

                    $drogas[] = $tipo['desc'];
                }

                $data = [
                    'labels' => $drogas,
                    'cantidades' => $cantidades,
                   
                ];

   
                echo json_encode($data);
                exit;
            
            
        } catch (Exception $e) {
            echo json_encode([
                "detalle" => $e->getMessage(),
                "mensaje" => "ocurrio un error en base de datos",

                "codigo" => 4,
            ]);
        }
    }
    function mapaCalorPorDeptoPistasAPI()
    {
        $fecha1 = str_replace('T', ' ', $_POST['fecha_mapa']);
        $fecha2 = str_replace('T', ' ', $_POST['fecha2']);

        $sql = " SELECT distinct dm_desc_lg as descripcion, dm_codigo as codigo, count (*) as cantidad FROM amc_topico inner join depmun on departamento = dm_codigo  where  amc_topico.situacion = 1 and amc_topico.tipo = 8 ";


        if ($fecha1 != '' && $fecha2 == '') {

            $sql .= "AND amc_topico.fecha = '$fecha1'";
        }
        if ($fecha1 != '' && $fecha2 != '') {
            $sql .= " AND amc_topico.fecha   BETWEEN '$fecha1' AND  '$fecha2' ";
        }
        if ($fecha1 == '' && $fecha2 == '') {
            $sql .= "  AND year(fecha) = year(current) AND month(fecha) = month(current)";
        }
        $sql .= " group by descripcion, codigo";

        $info = Droga::fetchArray($sql);


        echo json_encode($info);
    }

    function DrogasCantGraficaAPI(){
        

        $fecha1 = str_replace('T', ' ', $_POST['fecha_grafica']);
            $fecha2 = str_replace('T', ' ', $_POST['fecha_grafica2']);
   

      $tipos = static::drogas_tipo();
     
      $data = [];
      $labels = [];
      $drogas = [];
      $cantidades = [];
      $i = 0;
      $datos= 0;
  
     
        for($i = 13; $i <=14 ; $i++  ){
     $a = 0;
     $b = 0;
           foreach ($tipos as $key => $tipo ) {
     
              $droga = $tipo['id'];
              
              $labels[]= $tipo['desc'];
     
              $operaciones = static::departamental_grafica($i ,  $fecha1 , $fecha2, $depto="", $droga );
         
      if($i == 13){
     $dataset = 'KILOS';

     if((int) $operaciones[0]['cantidad'] > 0){
        $b = $b +1;

      }
        
      }else{
        if($i == 14){
        $dataset = 'MATAS';
        if((int) $operaciones[0]['cantidad'] > 0){
            $a = $a +1;
    
          }
       
        }
      }
      $cantidades[$dataset][]= (int) $operaciones[0]['cantidad'];
      

      
     }
     if($a > 0 || $b > 0){
        $datos = $datos +1;

     }
    
     }
     
     foreach ($tipos as $key => $tipo ) {
     
     $droga = $tipo['id'];
     
     $drogas[]= $tipo['desc'];
     }
     
     $data = [
     'labels' => $drogas,
     'cantidades' => $cantidades,
     'informacion' => $datos,
     ];
     
     echo json_encode($data);
     
     
     

    }


    
    function DrogasDepartamentoGraficaAPI(){
        

        $fecha1 = str_replace('T', ' ', $_POST['fecha_grafica']);
            $fecha2 = str_replace('T', ' ', $_POST['fecha_grafica2']);
   
            $sql ="SELECT depmun.dm_desc_lg as descripcion, count(*) as cantidad FROM amc_topico  inner join depmun on amc_topico.departamento = depmun.dm_codigo where  amc_topico.situacion = 1 and amc_topico.tipo in (4,8) ";
            
            if ($fecha1 != '' && $fecha2 != '') {
                $sql .= " AND amc_topico.fecha   BETWEEN '$fecha1' AND  '$fecha2' ";
            }
            if ($fecha1 == '' && $fecha2 == '') {
                $sql .= " AND year(fecha) = year(current) AND month(fecha) = month(current)";
            }
                $sql .= " group by dm_desc_lg";


            $info = Droga::fetchArray($sql);
         echo json_encode($info);
     
     

    }


    public function IncautacionesPorDiaGraficaAPI()
    {
        try {


            $diasMes =  date('t');
            $data = [];
            for ($i = 0; $i <=  $diasMes; $i++) {
                // $main = new Main();
                $sql ="SELECT count(*) as  cantidad  From amc_topico  where year(amc_topico.fecha) = year(current) and month(amc_topico.fecha) = month(current) and day(amc_topico.fecha) = day($i) and amc_topico.situacion = 1 and amc_topico.tipo = 4";
                $info = Droga::fetchArray($sql);
                $data['dias'][] = $i;
                if ($info[0]['cantidad'] == null) {

                    $valor = 0;
                } else {
                    $valor = $info[0]['cantidad'];
                }
                $data['cantidades'][] = $valor;
            }
            echo json_encode($data);
            exit;
        } catch (Exception $e) {
            echo json_encode([
                "detalle" => $e->getMessage(),
                "mensaje" => "ocurrio un error en base de datos",

                "codigo" => 4,
            ]);
        }
    }


    public function KilosPorDiaGraficaAPI(){
        try {

  $diasMes =  date('t');
   $data = [];
        for ($i=0; $i <=  $diasMes ; $i++) { 
            // $main = new Main();
            $sql ="SELECT sum(cantidad) as  cantidad  From amc_incautacion_droga inner join amc_topico on amc_incautacion_droga.topico = amc_topico.id  where year(amc_topico.fecha) = year(current) and month(amc_topico.fecha) = month(current) and day(amc_topico.fecha) = day($i) and amc_topico.situacion = 1 ";
            $info = Droga::fetchArray($sql);
            if ($info[0]['cantidad'] == null) {

                $info = 0;
            } else {
                $info = $info[0]['cantidad'];
            }
            $data['kilos'][] = $info;
           
        }

        echo json_encode($data);

            exit;
        } catch (Exception $e) {
            echo json_encode([
                "detalle" => $e->getMessage(),
                "mensaje" => "ocurrio un error en base de datos",

                "codigo" => 4,
            ]);
        }
    }


    public function MatasPorDiaGraficaAPI(){
        try {

  $diasMes =  date('t');
   $data = [];
        for ($i=0; $i <=  $diasMes ; $i++) { 
            // $main = new Main();
            $sql ="SELECT sum(cantidad_plantacion) as  cantidad  From amc_incautacion_droga inner join amc_topico on amc_incautacion_droga.topico = amc_topico.id  where year(amc_topico.fecha) = year(current) and month(amc_topico.fecha) = month(current) and day(amc_topico.fecha) = day($i) and amc_topico.situacion = 1 ";
            $info = Droga::fetchArray($sql);
            if ($info[0]['cantidad'] == null) {

                $info = 0;
            } else {
                $info = $info[0]['cantidad'];
            }
            $data['matas'][] = $info;
           
        }

        echo json_encode($data);

            exit;
        } catch (Exception $e) {
            echo json_encode([
                "detalle" => $e->getMessage(),
                "mensaje" => "ocurrio un error en base de datos",

                "codigo" => 4,
            ]);
        }
    }

    
    function incautaciones_por_mes_y_droga($mes, $droga, $años)
    {

        $sentencia = "SELECT sum(cantidad) as  cantidad  from amc_incautacion_droga inner join amc_topico on amc_incautacion_droga.topico = amc_topico.id where year(amc_topico.fecha) = $años and month(amc_topico.fecha) = $mes  and amc_topico.situacion = 1 and amc_incautacion_droga.situacion = 1 and amc_incautacion_droga.tipo_droga = $droga";
        $result = Droga::fetchArray($sentencia);
        if ($result[0]['cantidad'] == null) {

            $valor[0]['cantidad'] = 0;
        } else {
            $valor = $result[0]['cantidad'];
        }
       
       
       
        return $valor;
    }
   
    function incautacionesmatas_por_mes_y_droga($mes, $droga, $años)
    {
       
       
        $sentencia = "SELECT sum(cantidad) as  cantidad  from amc_incautacion_droga inner join amc_topico on amc_incautacion_droga.topico = amc_topico.id where year(amc_topico.fecha) = $años and  month(amc_topico.fecha) = $mes  and amc_topico.situacion = 1 and amc_incautacion_droga.situacion = 1 and amc_incautacion_droga.tip_droga_plantacion = $droga";
        $result = Droga::fetchArray($sentencia);
        if ($result[0]['cantidad'] == null) {

            $valor[0]['cantidad'] = 0;
        } else {
            $valor = $result[0]['cantidad'];
        }
       
       
       
        return $valor;
    }
   
   
    public function GraficatrimestralKilosAPI(){
        try {

            $mes = date("n");
            // $mes = 1;
            $año = date("Y");

            $meses = [];

            switch ($mes) {
                case '1':
                    $meses = [11, 12, 1];
                    $años = [$año - 1, $año - 1 , $año];
                    break;
                    case '2':
                    $meses = [12, 1, 2];
                    $años = [$año - 1, $año, $año];
                    
                    break;
                    default:
                    
                    $meses = [$mes - 2, $mes - 1, $mes];
                    $años = [$año, $año, $año];
                    break;
            }

            $tipos = static::drogas_tipo();

            $data = [];
            $labels = [];
            $cantidades = [];
            $i = 0;

            foreach($tipos as $tipo){
                $tipo_id = (int)$tipo['id'];
                $labels[] = $tipo['desc'];

                for($i = 0 ; $i < 3 ; $i++){
                    $dateObj = DateTime::createFromFormat('!m', $meses[$i]);
                    $mes = strftime("%B", $dateObj->getTimestamp());
                    $operaciones = static::incautaciones_por_mes_y_droga($meses[$i], $tipo_id, $años[$i]);
                    $cantidades[$mes][] = $operaciones[0]['cantidad'];
                }



            }
            $data = [
                'labels' => $labels,
                'cantidades' => $cantidades
            ];

            echo json_encode($data);
        } catch (Exception $e) {
            echo json_encode([
                "detalle" => $e->getMessage(),
                "mensaje" => "ocurrio un error en base de datos",

                "codigo" => 4,
            ]);
        }
    }
   
    public function GraficatrimestralMatasAPI(){
        try {

            $mes = date("n");
            // $mes = 1;
            $año = date("Y");

            $meses = [];

            switch ($mes) {
                case '1':
                    $meses = [11, 12, 1];
                    $años = [$año - 1, $año - 1 , $año];
                    break;
                    case '2':
                    $meses = [12, 1, 2];
                    $años = [$año - 1, $año, $año];
                    
                    break;
                    default:
                    
                    $meses = [$mes - 2, $mes - 1, $mes];
                    $años = [$año, $año, $año];
                    break;
            }

            $tipos = static::drogas_tipo();

            $data = [];
            $labels = [];
            $cantidades = [];
            $i = 0;

            foreach($tipos as $tipo){
                $tipo_id = (int)$tipo['id'];
                $labels[] = $tipo['desc'];

                for($i = 0 ; $i < 3 ; $i++){
                    $dateObj = DateTime::createFromFormat('!m', $meses[$i]);
                    $mes = strftime("%B", $dateObj->getTimestamp());
                    $operaciones = static::incautacionesmatas_por_mes_y_droga($meses[$i], $tipo_id, $años[$i]);
                    $cantidades[$mes][] = $operaciones[0]['cantidad'];
                }



            }
            $data = [
                'labels' => $labels,
                'cantidades' => $cantidades
            ];

            echo json_encode($data);
        } catch (Exception $e) {
            echo json_encode([
                "detalle" => $e->getMessage(),
                "mensaje" => "ocurrio un error en base de datos",

                "codigo" => 4,
            ]);
        }
    }
   


    public function GraficatrimestralPistasAPI(){
        try {

            $mes = date("n");
            // $mes = 1;
            $año = date("Y");

            $meses = [];

            switch ($mes) {
                case '1':
                    $meses = [11, 12, 1];
                    $años = [$año - 1, $año - 1 , $año];
                    break;
                    case '2':
                    $meses = [12, 1, 2];
                    $años = [$año - 1, $año, $año];
                    
                    break;
                    default:
                    
                    $meses = [$mes - 2, $mes - 1, $mes];
                    $años = [$año, $año, $año];
                    break;
            }

            $data = [];
            $cantidades = [];
            $i = 0;
            $meses1 =[];
           

                for($i = 0 ; $i < 3 ; $i++){
                    $dateObj = DateTime::createFromFormat('!m', $meses[$i]);
                    $mes1 = strftime("%B", $dateObj->getTimestamp());
                    $sql=" SELECT  count (*) as cantidad from amc_topico  where  year(amc_topico.fecha) = $años[$i] and month(amc_topico.fecha) = $meses[$i] and amc_topico.situacion = 1 and amc_topico.tipo = 8";
                    $info = Droga::fetchArray($sql);
                    $meses1[]= $mes1;
                    $cantidades[$mes1][]= (int) $info[0]['cantidad'];
                }
                
                $data = [
                    'meses' => $meses1,
                    'cantidades' => $cantidades
                ];
                
                echo json_encode($data);
        
           
        } catch (Exception $e) {
            echo json_encode([
                "detalle" => $e->getMessage(),
                "mensaje" => "ocurrio un error en base de datos",

                "codigo" => 4,
            ]);
        }
    }


    public function GraficaTrimestralIncautacionesGeneralAPI(){
        try {

            $mes = date("n");
            // $mes = 1;
            $año = date("Y");

            $meses = [];

            switch ($mes) {
                case '1':
                    $meses = [11, 12, 1];
                    $años = [$año - 1, $año - 1 , $año];
                    break;
                    case '2':
                    $meses = [12, 1, 2];
                    $años = [$año - 1, $año, $año];
                    
                    break;
                    default:
                    
                    $meses = [$mes - 2, $mes - 1, $mes];
                    $años = [$año, $año, $año];
                    break;
            }

            $data = [];
            $cantidades = [];
            $i = 0;
            $meses1 =[];
           

                for($i = 0 ; $i < 3 ; $i++){
                    $dateObj = DateTime::createFromFormat('!m', $meses[$i]);
                    $mes1 = strftime("%B", $dateObj->getTimestamp());
                    $sql=" SELECT  sum (cantidad) as cantidad from amc_incautacion_droga inner join amc_topico on amc_incautacion_droga.topico = amc_topico.id  where  year(amc_topico.fecha) = $años[$i] and month(amc_topico.fecha) = $meses[$i] and amc_topico.situacion = 1 and amc_incautacion_droga.situacion = 1";
                    $info = Droga::fetchArray($sql);
                    $meses1[]= $mes1;
                    $cantidades[$mes1][]= (int) $info[0]['cantidad'];
                }
                
                $data = [
                    'meses' => $meses1,
                    'cantidades' => $cantidades
                ];
                
                echo json_encode($data);
                
           
        } catch (Exception $e) {
            echo json_encode([
                "detalle" => $e->getMessage(),
                "mensaje" => "ocurrio un error en base de datos",

                "codigo" => 4,
            ]);
        }
    }
}
