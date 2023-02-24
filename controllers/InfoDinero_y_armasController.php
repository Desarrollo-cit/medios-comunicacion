<?php

namespace Controllers;

use Exception;
use DateTime;
use Model\Capturadas;
use Model\Muertes;
use Model\Delito;
use Model\DepMun;
// use Model\Delito;
use MVC\Router;

class InfoDinero_y_armasController
{

    public function index(Router $router)
    {
        $capturas = static::cantidadArmas();
        $total_dinero = static::total_dinero();
        $incidencia_arma = static::incidencia_arma();
        $total_armas = static::total_armas();
        $depto = static::departamento_con_mas_armas_incautadas();
        $colores = static::coloresAPI1();
        $delitos = static::delitosApi();
        $armas = static::armas();
        $router->render('mapas/dinero_y_armas', [
            'incidencia_arma' => $incidencia_arma,
            'capturas' => $capturas,
            'delitos' => $delitos,
            'total_dinero' => $total_dinero,
            'total_armas' => $total_armas,
            'depto' => $depto,
            'colores' => $colores,
            'armas' => $armas,
        ]);
    }


    protected static function cantidadArmas($fecha1 = "", $fecha2 = "")
    {


        $sql = "  SELECT count (*) as cantidad from amc_topico where amc_topico.situacion = 1 and amc_topico.tipo in (5,6)  ";

        if ($fecha1 != '' && $fecha2 != '') {

            $sql .= " AND amc_topico.fecha   BETWEEN '$fecha1' AND  '$fecha2' ";
        } else {

            $sql .= " AND year(amc_topico.fecha) = year(current)  and  month(amc_topico.fecha) = month(current) ";
        }
        $result = Muertes::fetchArray($sql);
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

    protected static function total_dinero($fecha1 = "", $fecha2 = "", $depto = "")
    {


        $sql = "  SELECT sum(conversion) as cantidad_din from amc_incautacion_dinero inner join amc_topico on amc_incautacion_dinero.topico = amc_topico.id  where   amc_topico.situacion = 1 and amc_incautacion_dinero.situacion = 1  ";

        if ($fecha1 != '' && $fecha2 != '') {

            $sql .= " AND amc_topico.fecha   BETWEEN '$fecha1' AND  '$fecha2' ";
        } else {

            $sql .= " AND year(amc_topico.fecha) = year(current)  and  month(amc_topico.fecha) = month(current) ";
        }
        if ($depto != '') {

            $sql .= " AND amc_topico.departamento = $depto";
        }

        $result = Muertes::fetchArray($sql);
        if ($result[0]["cantidad_din"] != null) {
            return $result;
        } else {

            $capturas = [[
                "cantidad_din" =>
                "0"
            ]];
            return $capturas;
        }
    }


    protected static function total_armas($fecha1 = "", $fecha2 = "", $depto = "", $arma = "")
    {


        $sql = "  SELECT sum(cantidad) as cantidad_arm from amc_detalle_arma inner join amc_topico on amc_detalle_arma.topico = amc_topico.id  where  amc_topico.situacion = 1 and amc_detalle_arma.situacion = 1 and amc_topico.tipo = 6";

        if ($fecha1 != '' && $fecha2 != '') {

            $sql .= " AND amc_topico.fecha   BETWEEN '$fecha1' AND  '$fecha2' ";
        } else {

            $sql .= " AND year(amc_topico.fecha) = year(current)  and  month(amc_topico.fecha) = month(current) ";
        }
        if ($depto != '') {

            $sql .= " AND amc_topico.departamento = $depto";
        }
        $result = Muertes::fetchArray($sql);
        if ($result[0]["cantidad_arm"] != null) {
            return $result;
        } else {

            $capturas = [[
                "cantidad_arm" =>
                "0"
            ]];
            return $capturas;
        }
    }


    function armas()
    {

        $sql = "SELECT * from amc_tipo_armas where situacion = 1";
        $result = Muertes::fetchArray($sql);
        return $result;
    }



    protected static function incidencia_arma($fecha1 = "", $fecha2 = "")
    {


        $sql = "  SELECT FIRST 1 amc_tipo_armas.desc as descripcion,  sum(amc_detalle_arma.cantidad) as cantidad, amc_calibre.desc as municion from amc_detalle_arma inner join amc_tipo_armas on amc_detalle_arma.tipo_arma = amc_tipo_armas.id inner join amc_calibre on amc_detalle_arma.calibre = amc_calibre.id inner join amc_topico on amc_detalle_arma.topico = amc_topico.id where  amc_detalle_arma.situacion = 1 and amc_topico.situacion = 1  ";


        if ($fecha1 != '' && $fecha2 != '') {

            $sql .= " AND amc_topico.fecha   BETWEEN '$fecha1' AND  '$fecha2' ";
        } else {

            $sql .= " AND year(amc_topico.fecha) = year(current)  and  month(amc_topico.fecha) = month(current) ";
        }

        $sql .= " group by descripcion, municion, cantidad order by cantidad desc";
        $result = Muertes::fetchArray($sql);
        if ($result[0]['descripcion'] != '') {


            return $result;
        } else {

            $incidencia_arma = [[
                "descripcion" =>
                "Sin datos",
                "municion" => ""
            ]];
            return $incidencia_arma;
        }
    }



    protected static function departamento_con_mas_armas_incautadas($fecha1 = "", $fecha2 = "")
    {
        $sql = "SELECT FIRST 1 amc_topico.departamento as departamento, sum(cantidad) as cantidad FROM amc_detalle_arma inner join amc_topico on amc_detalle_arma.topico = amc_topico.id  where   amc_topico.situacion = 1  and amc_topico.tipo= 6 ";
        if ($fecha1 != '' && $fecha2 != '') {

            $sql .= " AND amc_topico.fecha   BETWEEN '$fecha1' AND  '$fecha2' ";
        } else {

            $sql .= " AND year(amc_topico.fecha) = year(current)  and  month(amc_topico.fecha) = month(current) ";
        }

        $sql .= " group by departamento order by cantidad desc";



        $result1 = Muertes::fetchArray($sql);

        if ($result1) {

            $depto = $result1[0]['departamento'];

            $sql = "SELECT dm_desc_lg as desc from depmun where dm_codigo = $depto ";
            $result1 = Muertes::fetchArray($sql);
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



        $capturas = static::cantidadArmas($fecha1, $fecha2);
        $total_dinero = static::total_dinero($fecha1, $fecha2);
        $incidencia_arma = static::incidencia_arma($fecha1, $fecha2);
        $total_armas = static::total_armas($fecha1, $fecha2);
        $depto = static::departamento_con_mas_armas_incautadas($fecha1, $fecha2);
        $armas = static::armas();

        $array_resultante = array_merge($capturas,  $incidencia_arma, $total_armas, $depto, $total_dinero, $armas);

        echo json_encode($array_resultante);
    }


    public function listadoAPI()
    {
        getHeadersApi();


        try {

            $sql = " SELECT DISTINCT  amc_topico.id as id, amc_topico.lugar as lugar, amc_topico.tipo as tipo, amc_tipo_topics.desc as topico,  
            amc_topico.fecha as fecha, dm_desc_lg as departamento,   amc_actividad_vinculada.desc as actividad from amc_topico 
            inner join amc_tipo_topics on amc_topico.tipo = amc_tipo_topics.id inner join depmun on amc_topico.departamento = depmun.dm_codigo  
            inner join amc_actividad_vinculada on amc_topico.actividad = amc_actividad_vinculada.id and amc_topico.tipo in (5,6) and amc_topico.situacion = 1
        ";
            $info =  Capturadas::fetchArray($sql);

            $data = [];

            $i = 1;
            foreach ($info as $key) {
                $id = $key['id'];
                $lugar = $key['lugar'];
                $fecha = $key['fecha'];
                $departamento = $key['departamento'];
                $topico = $key['topico'];
                $tipo = $key['tipo'];
                $tipo1 = $key['tipo'];
                $situacion = $key['tipo'];
                $actividad = $key['actividad'];

                switch ($tipo) {


                    case "5":

                        $tipo = "INCAUTACION DE DINERO";
                        break;
                    case "6":

                        $tipo = "INCAUTACION DE ARMAS";
                        break;
                }



                $arrayInterno = [[
                    "contador" => $i,
                    "id" => $id,
                    "lugar" => $lugar,
                    "fecha" => $fecha,
                    "departamento" => $departamento,
                    "topico" => $topico,
                    "tipo" => $tipo,
                    "tipo1"=> $tipo1,
                    "situacion" => $situacion,
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


            $sql = "     SELECT amc_topico.id, fecha, lugar, dm_desc_lg, departamento, municipio as muni, tipo,latitud,longitud,actividad, amc_topico.situacion, depmun.dm_desc_lg as departamento1, amc_actividad_vinculada.desc as act, amc_tipo_topics.desc as topico from amc_topico inner join depmun on depmun.dm_codigo=amc_topico.departamento 
            inner join amc_actividad_vinculada on amc_actividad_vinculada.id=amc_topico.actividad
            inner join amc_tipo_topics on amc_topico.tipo = amc_tipo_topics.id
             where amc_topico.id = $id and amc_topico.situacion = 1";
            $info = Muertes::fetchArray($sql);
            $data = [];


            $i = 1;
            foreach ($info as $key) {
                $id = $key['id'];
                $lugar = $key['lugar'];
                $fecha = $key['fecha'];
                $depto = trim($key['dm_desc_lg']);
                $depto1 = trim((string)$key['departamento']);
                $muni = $key['muni'];
                $latitud = $key['latitud'];
                $longitud = $key['longitud'];
                $tipo = $key['topico'];
                //  $delito = $key['delito'];
                $actividad = $key['act'];


                if ($depto1 < 1000) {

                    $depto1 = '0' . $depto1;
                }

                //    $sql1 = "SELECT dm_desc_md as municipio from depmun where dm_codigo = $municipio ";

                $municipio = DepMun::fetchArray("SELECT dm_desc_lg from depmun where dm_codigo = $muni");
                //    foreach($municipio as $key1){ 
                //     $nombreMuni = $key1['dm_desc_lg'];

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
                    //"delito" => $delito,
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



    public function informacionModalAPI1()
    {
        getHeadersApi();

        // echo json_encode($sql);

        try {

            $id = $_POST['id'];

            $sql = "
            SELECT amc_moneda.desc as tipo_dinero,  amc_incautacion_dinero.moneda as tipo_moneda,  amc_incautacion_dinero.cantidad as cantidad1  
            from amc_incautacion_dinero inner join amc_moneda on amc_incautacion_dinero.moneda = amc_moneda.id  
            
            where amc_incautacion_dinero.topico =$id 
            and  amc_incautacion_dinero.situacion = 1
           ";
            $info = Capturadas::fetchArray($sql);
            $data = [];

            $i = 1;
            foreach ($info as $key) {

                $tipo_dinero = utf8_encode($key['tipo_dinero']);
                //$nacionalidad = utf8_encode($key['nacionalidad']);

                $cantidad = $key['cantidad'];
                // $delito = utf8_encode($key['delito']);
             





                $arrayInterno = [[
                    "contador" => $i,

               
                    //"nacionalidad" => $nacionalidad,
                    "dinero" => $tipo_dinero,
                    "cantidad" => $cantidad,





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
    public function informacionModalAPI()
    {
        getHeadersApi();

        // echo json_encode($sql);

        try {

            $id = $_POST['id'];

            $sql = "SELECT amc_tipo_armas.desc as tipo_arma, amc_calibre.desc as calibre, amc_detalle_arma.cantidad as cantidad  from amc_detalle_arma inner join amc_tipo_armas on amc_tipo_armas.id = amc_detalle_arma.tipo_arma inner join amc_calibre on amc_calibre.id = amc_detalle_arma.calibre  where amc_detalle_arma.topico = $id and amc_detalle_arma.situacion = 1";
            $info = Capturadas::fetchArray($sql);
            $data = [];

            $i = 1;
            if($info){
                foreach($info as $key){ 
                     $tipo_arma = $key['tipo_arma'];
                   $calibre = $key['calibre'];
                   $cantidad = $key['cantidad'];
                  
                    $arrayInterno = [[
                       "contador" => $i,
                       "tipo_arma" => $tipo_arma,
                       "calibre" => $calibre,
                       "cantidad" => $cantidad  
                    
                   ]];
                   $i++;
                   $data = array_merge($data,$arrayInterno);
                
                
                }}
                
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


    public function mapaCalorAPI()
    {
        getHeadersApi();

        // echo json_encode($sql);

        try {
            $tipo_arma = $_POST['tipos_arma_mapa_calor'];
            $fecha1 = str_replace('T', ' ', $_POST['fecha_mapa']);
            $fecha2 = str_replace('T', ' ', $_POST['fecha2']);



            $sql = " SELECT distinct dm_desc_lg as descripcion, dm_codigo as codigo, count (*) as cantidad FROM amc_topico inner join depmun on departamento = dm_codigo  ";

            if ($tipo_arma != '') {

                $sql .= " inner join amc_detalle_arma on amc_topico.id = amc_detalle_arma.topico where   amc_detalle_arma.tipo_arma = $tipo_arma and amc_topico.situacion = 1 and amc_detalle_arma.situacion = 1 ";
            } else {


                $sql .= " where  amc_topico.situacion = 1";
                $sql .= " and amc_topico.tipo in (5,6) ";
            }
            if ($fecha1 != '' && $fecha2 == '') {

                $sql .= "AND amc_topico.fecha = '$fecha1'";
            }
            if ($fecha1 != '' && $fecha2 != '') {
                $sql .= " AND amc_topico.fecha   BETWEEN '$fecha1' AND  '$fecha2' ";
            }
            if ($fecha1 == '' && $fecha2 == '') {
                $sql .= " AND year(fecha) = year(current) AND month(fecha) = month(current)";
            }

            $sql .= " group by descripcion, codigo";

            $info = Muertes::fetchArray($sql);
            echo json_encode($info);
        } catch (Exception $e) {
            echo json_encode([
                "detalle" => $e->getMessage(),
                "mensaje" => "ocurrio un error en base de datos",

                "codigo" => 4,
            ]);
        }
    }


    public function coloresAPI()
    {
        getHeadersApi();
        try {
            $sql = "SELECT * from amc_colores where topico = 5 and situacion = 1 order by nivel asc ";
            $info = Capturadas::fetchArray($sql);
            echo json_encode($info);
        } catch (Exception $e) {
            return [];
        }
    }


    public function mapaCalorDeptoAPI()
    {
        getHeadersApi();
        try {

            $depto = $_POST['departamento'];
            $arma = $_POST['tipos_arma_mapa_calor'];

            $fecha1 = str_replace('T', ' ', $_POST['fecha_mapa']);
            $fecha2 = str_replace('T', ' ', $_POST['fecha2']);

            $incidencia_arma = static::incidencia_arma($fecha1, $fecha2,  $depto, $arma);
            $total_armas = static::total_armas($fecha1, $fecha2,  $depto, $arma);
            $total_dinero = static::total_dinero($fecha1, $fecha2,  $depto);


            $array_resultante = array_merge($incidencia_arma, $total_armas, $total_dinero);

            echo json_encode($array_resultante);
        } catch (Exception $e) {
            echo json_encode([
                "detalle" => $e->getMessage(),
                "mensaje" => "ocurrio un error en base de datos",

                "codigo" => 4,
            ]);
        }
    }


    public function coloresAPI1()
    {

        try {
            $sql = "SELECT * from amc_colores where topico = 5  ";
            $info = Capturadas::fetchArray($sql);
            return $info;
        } catch (Exception $e) {
            return [];
        }
    }


    public function delitosApi()
    {

        try {
            $sql = "SELECT * from amc_delito where situacion = 1  ";
            $info = Delito::fetchArray($sql);
            return $info;
        } catch (Exception $e) {
            return [];
        }
    }

    public function mapaCalorPorDeptoGraficaAPI()
    {
        try {



            $depto = $_POST['departamento'];
            $arma = $_POST['tipos_arma_mapa_calor'];
            $fecha1 = str_replace('T', ' ', $_POST['fecha_mapa']);
            $fecha2 = str_replace('T', ' ', $_POST['fecha2']);

            $armas = static::armas();

            foreach ($armas as $key => $tipo) {
                $arma = $tipo["id"];
                $arma_n = $tipo["desc"];

                $total = static::total($depto, $arma,  $fecha1, $fecha2);
                $dataset = 'armas';
                $cantidades[$dataset][] = (int) $total[0]['cantidad'];
            }


            foreach ($armas as $key => $tipo) {

                $arma = $tipo["id"];
                $arma_nom[] = $tipo["desc"];
            }
            // $cantidades[$arma_n]=$total[0]["cantidad"];

            //$descripcion = 'ARMAS';
            //      $array_resultante=  array_merge($cantidades , $descripcion );
            $data = [
                'descripcion' => $arma_nom,
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

    protected static function total($depto = "", $arma = "", $fecha1 = "", $fecha2 = "")
    {

        try {
            $sql = "SELECT sum(cantidad) as cantidad from amc_detalle_arma inner join amc_topico on amc_detalle_arma.topico = amc_topico.id  where  amc_topico.situacion = 1 and amc_detalle_arma.situacion = 1 and amc_topico.tipo = 6";


            if ($depto != '') {

                $sql .= " AND amc_topico.departamento = $depto";
            }
            if ($arma != '' && $arma != 0) {

                $sql .= " AND amc_detalle_arma.tipo_arma = $arma";
            }


            if ($fecha1 != '' && $fecha2 != '') {

                $sql .= " AND amc_topico.fecha   BETWEEN '$fecha1' AND  '$fecha2' ";
            }
            $result = Muertes::fetchArray($sql);
            if ($result[0]["cantidad"] != null) {
                return $result;
            } else {

                $result = [[
                    "cantidad" =>
                    "0"
                ]];
                return $result;
            }
        } catch (Exception $e) {
            echo json_encode([
                "detalle" => $e->getMessage(),
                "mensaje" => "ocurrio un error en base de datos",

                "codigo" => 4,
            ]);
        }
    }




    //// PARTE DE LAS GRAFICAS 


    public function DelitosCantGraficaAPI()
    {
        try {

            try {



                $depto = $_POST['departamento'];
                $arma = $_POST['tipos_arma_mapa_calor'];
                $fecha1 = str_replace('T', ' ', $_POST['fecha_mapa']);
                $fecha2 = str_replace('T', ' ', $_POST['fecha2']);

                $armas = static::armas();

                foreach ($armas as $key => $tipo) {
                    $arma = $tipo["id"];
                    $arma_n = $tipo["desc"];

                    $total = static::total($depto, $arma,  $fecha1, $fecha2);
                    $dataset = 'armas';
                    $cantidades[$dataset][] = (int) $total[0]['cantidad'];
                }


                foreach ($armas as $key => $tipo) {

                    $arma = $tipo["id"];
                    $arma_nom[] = $tipo["desc"];
                }
                // $cantidades[$arma_n]=$total[0]["cantidad"];

                //$descripcion = 'ARMAS';
                //      $array_resultante=  array_merge($cantidades , $descripcion );
                $data = [
                    'descripcion' => $arma_nom,
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
        } catch (Exception $e) {
            echo json_encode([
                "detalle" => $e->getMessage(),
                "mensaje" => "ocurrio un error en base de datos",

                "codigo" => 4,
            ]);
        }
    }


    public function DineroCantGraficaAPI()
    {
        try {

            try {



                $depto = $_POST['departamento'];
                $arma = $_POST['tipos_arma_mapa_calor'];
                $fecha1 = str_replace('T', ' ', $_POST['fecha_mapa']);
                $fecha2 = str_replace('T', ' ', $_POST['fecha2']);

                // $armas = static::armas();


                $sql = "SELECT cantidad, desc  From amc_incautacion_dinero inner join amc_topico on amc_incautacion_dinero.topico = amc_topico.id inner join amc_moneda on moneda=amc_moneda.id
                where  amc_topico.situacion = 1 and amc_topico.tipo IN (5,6)
              ";




                if ($fecha1 != '' && $fecha2 != '') {

                    $sql .= " AND amc_topico.fecha   BETWEEN '$fecha1' AND  '$fecha2' ";
                } else {

                    $sql .= " AND year(amc_topico.fecha) = year(current)  and  month(amc_topico.fecha) = month(current) ";
                }




                $info = Capturadas::fetchArray($sql);
                $cantidades = [];

                foreach ($info as $row) {
                    $labels[] = $row['desc'];
                    $cantidades[] = $row['cantidad'];
                }

                echo json_encode([
                    'cantidades' => $cantidades,
                    'labels' => $labels,
                ]);
            } catch (Exception $e) {
                echo json_encode([
                    "detalle" => $e->getMessage(),
                    "mensaje" => "ocurrio un error en base de datos",

                    "codigo" => 4,
                ]);
            }
        } catch (Exception $e) {
            echo json_encode([
                "detalle" => $e->getMessage(),
                "mensaje" => "ocurrio un error en base de datos",

                "codigo" => 4,
            ]);
        }
    }


    public function CapturasPorDiaGraficaAPI()
    {
        try {
            /* SELECT sum(cantidad) as  cantidad  From amc_incautacion_dineros inner join amc_topico on amc_incautacion_dinero.topico = amc_topico.id   where year(amc_topico.fecha) = year(current) and month(amc_topico.fecha) = month(current) and day(amc_topico.fecha) = day($i) and amc_topico.situacion = 1 and amc_topico.tipo IN (5,6) */

            $diasMes =  date('t');
            $data = [];
            for ($i = 0; $i <=  $diasMes; $i++) {
                // $main = new Main();
                $sql = "SELECT count(*) as  cantidad  From amc_incautacion_dinero inner join amc_topico on amc_incautacion_dinero.topico = amc_topico.id where year(amc_topico.fecha) = year(current) and month(amc_topico.fecha) = month(current) and day(amc_topico.fecha) = day($i) and amc_topico.situacion = 1 and amc_incautacion_dinero.situacion = 1";
                $info = Capturadas::fetchArray($sql);
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




    public function CapturasPorDiaGrafica_armasAPI()
    {
        try {
            /* SELECT sum(cantidad) as  cantidad  From amc_incautacion_dineros inner join amc_topico on amc_incautacion_dinero.topico = amc_topico.id   where year(amc_topico.fecha) = year(current) and month(amc_topico.fecha) = month(current) and day(amc_topico.fecha) = day($i) and amc_topico.situacion = 1 and amc_topico.tipo IN (5,6) */

            $diasMes =  date('t');
            $data = [];
            for ($i = 0; $i <=  $diasMes; $i++) {
                // $main = new Main();
                $sql = "SELECT count(*) as  cantidad  From amc_incautacion_armas inner join amc_topico on amc_incautacion_armas.topico = amc_topico.id where year(amc_topico.fecha) = year(current) and month(amc_topico.fecha) = month(current) and day(amc_topico.fecha) = day($i) and amc_topico.situacion = 1 and amc_incautacion_armas.situacion = 1";
                $info = Capturadas::fetchArray($sql);
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



    public function GraficaTrimestralAPI()
    {
        try {

            $mes = date("n");
            // $mes = 1;
            $año = date("Y");

            $meses = [];

            switch ($mes) {
                case '1':
                    $meses = [11, 12, 1];
                    $años = [$año - 1, $año - 1, $año];
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
            $labels = [];
            $cantidades = [];
            $i = 0;
            $a = 0;
        
            $armas = static::armas();

          


            foreach ($armas as $key => $tipo) {

                $arma = $tipo["id"];
                $labels[] = $tipo["desc"];
            }


            for ($a = 1; $a <= 5; $a++) {

                $tipo_id = $a;

        /*         switch ($a) {
                    case "1":
                        $labels[] = "ASESINATO";
                        break;
                    case "2":
                        $labels[] = "HOMICIDIO";
                        break;
                    case "3":
                        $labels[] = "SICARIATO";
                        break;
                    case "4":
                        $labels[] = "FEMICIDIO";
                        break;
                    case "5":
                        $labels[] = "SUICIDIO";
                        break;
                } */

        

                for ($i = 0; $i < 3; $i++) {
                    $dateObj = DateTime::createFromFormat('!m', $meses[$i]);
                    $mes = strftime("%B", $dateObj->getTimestamp());
                    $operaciones = static::capturas_por_mes_y_delito($meses[$i], $tipo_id, $años[$i]);
                    $cantidades[$mes][] = $operaciones['cantidad'];
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



    
    public function GraficaTrimestralGeneralAPI()
    {
        try {


            $monthNum = date("n");
            //   $monthNum = 12;
            $año = date("Y");
            $año_anterior = 0;
            if ($monthNum == 1) {
                $mes_en_query = 11;
                $valor_final = 11;
                $fechainicial = 12;
                $año_anterior = $año - 1;
            }
            if ($monthNum == 2) {
                $mes_en_query = 12;
                $valor_final = 12;
                $fechainicial = 13;
                $año_anterior = $año - 1;
            }

            if ($monthNum > 2) {
                $mes_en_query =  $monthNum - 2;
                $valor_final = $monthNum - 2;
                $fechainicial = $monthNum;
            }




            $data = [];
            $meses = [];
            $cantidades = [];
            $i = 0;
            $vuelta = 0;
            $ronda = 0;



            for ($i = $valor_final; $i <= $fechainicial; $i++) {

                $dateObj = DateTime::createFromFormat('!m', $mes_en_query);
                $mes = strftime("%B", $dateObj->getTimestamp());
                $sql = " SELECT  count (*) as cantidad from amc_incautacion_armas inner join amc_topico on amc_incautacion_armas.topico = amc_topico.id  where month(amc_topico.fecha) = $mes_en_query and amc_topico.situacion = 1 and amc_incautacion_armas.situacion > 0";

                if ($monthNum == 1 && $vuelta < 2 && $monthNum < 11) {
                    $sql .= " AND year(amc_topico.fecha) =   $año_anterior ";
                    $vuelta = $vuelta + 1;
                }
                if ($monthNum == 2 && $vuelta == 0 && $monthNum < 11) {
                    $sql .= " AND year(amc_topico.fecha) =   $año_anterior ";
                    $vuelta = $vuelta + 1;
                }
                if ($monthNum > 2) {
                    $sql .= " AND year(amc_topico.fecha) =   $año ";
                }

                //  echo json_encode($sql);
                //  exit;
                $info = Capturadas::fetchArray($sql);
                $meses[] = $mes;
                $cantidades[$mes] = (int) $info[0]['cantidad'];





                if ($mes_en_query < 13 && $mes_en_query > 10 && $monthNum < 11) {

                    if ($mes_en_query == 12) {
                        $mes_en_query = 0;
                    }
                    if ($mes_en_query == 11) {
                        $mes_en_query = 11;
                    }
                    $i = 0;
                    $ronda = $ronda + 1;
                    if ($ronda == 2) {
                        $fechainicial = 1;
                    }
                    if ($ronda == 1) {
                        $fechainicial = 2;
                    }
                }
                $mes_en_query = $mes_en_query + 1;
            }


            $data = [

                'cantidades' => $cantidades,
                'meses' => $meses
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



    
    function capturas_por_mes_y_delito($mes, $delito, $año)
    {

        $sentencia = "SELECT sum(cantidad) as  cantidad  from amc_detalle_arma inner join amc_topico on amc_detalle_arma.topico = amc_topico.id where year(amc_topico.fecha) = year(current) and month(amc_topico.fecha) = $mes  and amc_topico.situacion = 1 and amc_detalle_arma.situacion = 1 and amc_detalle_arma.tipo_arma = $delito";
        // if($año != ""){
        //         $sentencia .= " AND year(amc_topico.fecha) = $año   ";
        // }else{

        //     $sentencia .= " AND year(amc_topico.fecha) = year(current) ";
        // }
        $result = Capturadas::fetchArray($sentencia);
        return array_shift($result);
    }


    function capturas_por_mes_y_dinero($mes, $delito, $año)
    {

        $sentencia = "SELECT sum(cantidad) as  cantidad  from amc_detalle_municion inner join amc_topico on amc_detalle_municion.topico = amc_topico.id where year(amc_topico.fecha) = year(current) and month(amc_topico.fecha) = $mes  and amc_topico.situacion = 1 and amc_detalle_municion.situacion = 1 and amc_detalle_municion.calibre = $delito";
        // if($año != ""){
        //         $sentencia .= " AND year(amc_topico.fecha) = $año   ";
        // }else{

        //     $sentencia .= " AND year(amc_topico.fecha) = year(current) ";
        // }
        $result = Capturadas::fetchArray($sentencia);
        return array_shift($result);
    }


    public function DelitosDepartamentoGraficaAPI()
    {
        try {



            $fecha1 = str_replace('T', ' ', $_POST['fecha_grafica']);
            $fecha2 = str_replace('T', ' ', $_POST['fecha_grafica2']);



            $sql = "SELECT trim(depmun.dm_desc_lg) as descripcion, sum(cantidad) as cantidad 
            FROM amc_detalle_arma inner join amc_topico on amc_detalle_arma.topico = amc_topico.id  
            inner join depmun on amc_topico.departamento = depmun.dm_codigo where amc_topico.situacion = 1 and amc_topico.tipo = 6  ";




            if ($fecha1 != '' && $fecha2 != '') {

                $sql .= " AND amc_topico.fecha   BETWEEN '$fecha1' AND  '$fecha2' ";
            } else {

                $sql .= " AND year(amc_topico.fecha) = year(current)  and  month(amc_topico.fecha) = month(current) ";
            }


            $sql .= "group by dm_desc_lg";
            $info = Capturadas::fetchArray($sql);

            if ($info) {


                $info[1]["codigo"] = [

                    1,
                ];
                echo json_encode($info);
            } else {

                $info[1] = [
                    "descripcion" => "",
                    "cantidad" => 0,
                    "codigo" => 2,
                ];

                echo json_encode($info);
            }
        } catch (Exception $e) {
            echo json_encode([
                "detalle" => $e->getMessage(),
                "mensaje" => "ocurrio un error en base de datos",

                "codigo" => 4,
            ]);
        }
    }

    public function DineroDepartamentoGraficaAPI()
    {
        try {



            $fecha1 = str_replace('T', ' ', $_POST['fecha_grafica']);
            $fecha2 = str_replace('T', ' ', $_POST['fecha_grafica2']);



            $sql = "select trim(dm_desc_lg) as departamento, count(*) as cantidad from amc_topico inner join amc_incautacion_dinero on amc_topico.id = amc_incautacion_dinero.topico 
            inner join depmun on amc_topico.departamento = depmun.dm_codigo where amc_topico.situacion = 1  ";




            if ($fecha1 != '' && $fecha2 != '') {

                $sql .= " AND amc_topico.fecha   BETWEEN '$fecha1' AND  '$fecha2' ";
            } else {

                $sql .= " AND year(amc_topico.fecha) = year(current)  and  month(amc_topico.fecha) = month(current) ";
            }


            $sql .= "  group by dm_desc_lg";
            $info = Capturadas::fetchArray($sql);

            if ($info) {


                $info[1]["codigo"] = [

                    1,
                ];
                echo json_encode($info);
            } else {

                $info[1] = [
                    "descripcion" => "",
                    "cantidad" => 0,
                    "codigo" => 2,
                ];

                echo json_encode($info);
            }
        } catch (Exception $e) {
            echo json_encode([
                "detalle" => $e->getMessage(),
                "mensaje" => "ocurrio un error en base de datos",

                "codigo" => 4,
            ]);
        }
    }
}
