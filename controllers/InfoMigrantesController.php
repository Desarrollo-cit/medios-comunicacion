<?php

namespace Controllers;

use Exception;

use DateTime;
use Model\Migrantes;


use MVC\Router;

class InfoMigrantesController
{

    public function index(Router $router)
    {
        $migrantes = static::migrantes();
        $edades = static::edades();
        $edades_rango = static::tipos_de_edades();
        $cant_paises = static::cant_paises();
        $pais = static::pais();
        $mujeres = static::mujeres();
        $hombres = static::hombres();
        $colores = static::coloresAPI1();
        $depto = static::departamento_migrantes();
  
        $router->render('mapas/migrantes', [
            'migrantes' => $migrantes,
            'edades' => $edades,
            'edades_rango' => $edades_rango,
            'cant_paises' => $cant_paises,
            'pais' => $pais,
            'mujeres' => $mujeres,
            'hombres' => $hombres,
            'depto' => $depto,
            'colores' => $colores,
            
        ]);
    }



    function migrantes($fecha1 = "", $fecha2 = "")
    {


        $sql =  "SELECT sum (cantidad ) as cantidad from amc_migrantes inner join amc_topico on amc_migrantes.topic = amc_topico.id  where  amc_topico.situacion = 1 and amc_migrantes.situacion = 1 ";
        if ($fecha1 != '' && $fecha2 != '') {

            $sql .= " AND amc_topico.fecha   BETWEEN '$fecha1' AND  '$fecha2' ";
        } else {

            $sql .= " AND year(amc_topico.fecha) = year(current)  and  month(amc_topico.fecha) = month(current) ";
        }
        $result = Migrantes::fetchArray($sql);
        if ($result[0]['cantidad'] != NULL) {
            return $result;
        } else {

            $delito = [[
                "cantidad" =>
                "Sin datos"
            ]];
            return $delito;
        }
    }

    function edades($fecha1 = "", $fecha2 = "")
    {


        $sql = " SELECT first 1 amc_edades.edades , sum (cantidad ) as cantidad from amc_migrantes inner join amc_topico on amc_migrantes.topic = amc_topico.id inner join amc_edades on amc_migrantes.edad = amc_edades.id  where  amc_topico.situacion = 1 and amc_migrantes.situacion > 0  ";

        if ($fecha1 != '' && $fecha2 != '') {

            $sql .= " AND amc_topico.fecha   BETWEEN '$fecha1' AND  '$fecha2' ";
        } else {

            $sql .= " AND year(amc_topico.fecha) = year(current)  and  month(amc_topico.fecha) = month(current) ";
        }


        $sql .= " group by edades ";
        $edades = Migrantes::fetchArray($sql);
        if ($edades[0]['cantidad'] != NULL) {


            return $edades;
        } else {
            $edades = [[
                'edades' => "Sin datos"
            ]];
            return $edades;
        }
    }

    function cant_paises($fecha1 = "", $fecha2 = "")
    {

        $sql = " SELECT count(DISTINCT pais_migrante) as cantidad from amc_migrantes inner join amc_topico on amc_topico.id = amc_migrantes.topic where amc_topico.situacion = 1";

        if ($fecha1 != '' && $fecha2 != '') {

            $sql .= " AND amc_topico.fecha   BETWEEN '$fecha1' AND  '$fecha2' ";
        } else {

            $sql .= " AND year(amc_topico.fecha) = year(current)  and  month(amc_topico.fecha) = month(current) ";
        }
        $result = Migrantes::fetchArray($sql);
        if ($result[0]['cantidad'] != NULL) {
            return $result;
        } else {

            $delito = [[
                "cantidad" =>
                "Sin datos"
            ]];
            return $delito;
        }
    }

    function pais($fecha1 = "", $fecha2 = "")
    {

        $cero = [];
        $sql = "  SELECT FIRST 1 paises.pai_desc_lg as pais, sum (cantidad ) as cantidad from amc_migrantes inner join amc_topico on amc_migrantes.topic = amc_topico.id inner join amc_nacionalidad on amc_migrantes.pais_migrante = amc_nacionalidad.id inner join paises on paises.pai_codigo = amc_nacionalidad.pais where  amc_topico.situacion = 1 and amc_migrantes.situacion > 0 ";

        if ($fecha1 != '' && $fecha2 != '') {

            $sql .= " AND amc_topico.fecha   BETWEEN '$fecha1' AND  '$fecha2' ";
        } else {

            $sql .= " AND year(amc_topico.fecha) = year(current)  and  month(amc_topico.fecha) = month(current) ";
        }

        $sql .= "group by pai_desc_lg order by cantidad desc ";
        $result = Migrantes::fetchArray($sql);

        if ($result[0]['cantidad'] != NULL) {
            return $result;
        } else {

            $result =  array($cero = ["pais" => "Sin datos"]);
            return $result;
        }
    }


    function mujeres($fecha1 = "", $fecha2 = "")
    {


        $sql =  "SELECT sum (cantidad ) as cantidad from amc_migrantes inner join amc_topico on amc_migrantes.topic = amc_topico.id  where  amc_topico.situacion = 1 and amc_migrantes.situacion = 1 and sexo = 2 ";

        if ($fecha1 != '' && $fecha2 != '') {

            $sql .= " AND amc_topico.fecha   BETWEEN '$fecha1' AND  '$fecha2' ";
        } else {

            $sql .= " AND year(amc_topico.fecha) = year(current)  and  month(amc_topico.fecha) = month(current) ";
        }
        $result = Migrantes::fetchArray($sql);
        if ($result[0]['cantidad'] != NULL) {
            return $result;
        } else {

            $result =  array($cero = ["cantidad" => "Sin datos"]);
            return $result;
        }
    }

    function hombres($fecha1 = "", $fecha2 = "")
    {
        $sql = "SELECT  sum (cantidad ) as cantidad from amc_migrantes inner join amc_topico on amc_migrantes.topic = amc_topico.id   where amc_topico.situacion = 1 and sexo = 1 and amc_migrantes.situacion = 1";
        if ($fecha1 != '' && $fecha2 != '') {

            $sql .= " AND amc_topico.fecha   BETWEEN '$fecha1' AND  '$fecha2' ";
        } else {

            $sql .= " AND year(amc_topico.fecha) = year(current)  and  month(amc_topico.fecha) = month(current) ";
        }
        $result = Migrantes::fetchArray($sql);
        if ($result[0]['cantidad'] != NULL) {
            return $result;
        } else {

            $result =  array($cero = ["cantidad" => "Sin datos"]);
            return $result;
        }
    }

    function departamento_migrantes($fecha1 = "", $fecha2 = "")
    {
        $sql = "SELECT FIRST 1 amc_topico.departamento, count(*) as cantidad FROM amc_topico inner join amc_migrantes on amc_topico.id = amc_migrantes.topic where    amc_topico.situacion = 1 ";
        if ($fecha1 != '' && $fecha2 != '') {

            $sql .= " AND amc_topico.fecha   BETWEEN '$fecha1' AND  '$fecha2' ";
        } else {

            $sql .= " AND year(amc_topico.fecha) = year(current)  and  month(amc_topico.fecha) = month(current) ";
        }


        $sql .= "group by departamento order by cantidad desc";



        $result = Migrantes::fetchArray($sql);

        if ($result[0]['cantidad'] != NULL) {
            foreach ($result as $row) {

                $depto = $row['departamento'];
            }

            $sql = "SELECT dm_desc_lg as desc from depmun where dm_codigo = $depto ";
            $result = Migrantes::fetchArray($sql);
            return $result;
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



        $migrantes = static::migrantes($fecha1, $fecha2);
        $cant_paises = static::cant_paises($fecha1, $fecha2);
        $mujeres = static::mujeres($fecha1, $fecha2);
        $hombres = static::hombres($fecha1, $fecha2);
        $depto = static::departamento_migrantes($fecha1, $fecha2);
        $edades = static::edades($fecha1, $fecha2);
        $pais = static::pais($fecha1, $fecha2);
        $array_resultante = array_merge($migrantes, $edades, $cant_paises, $pais,  $mujeres, $hombres, $depto);

        echo json_encode($array_resultante);
    }

    public function listadoAPI()
    {
        getHeadersApi();


        try {

            $sql = "      SELECT DISTINCT amc_topico.id as id, amc_topico.lugar as lugar, amc_topico.tipo as tipo, amc_tipo_topics.desc as topico,  amc_topico.fecha as fecha, dm_desc_lg as departamento,   paises.pai_desc_lg as pais,  amc_edades.edades as edad, amc_migrantes.cantidad from amc_topico inner join amc_migrantes on topic = amc_topico.id inner join paises on paises.pai_codigo = amc_migrantes.pais_migrante  inner join amc_tipo_topics on amc_topico.tipo = amc_tipo_topics.id inner join depmun on amc_topico.departamento = depmun.dm_codigo  inner join amc_edades on amc_edades.id = amc_migrantes.edad and amc_migrantes.situacion = 1 and amc_topico.situacion = 1 and amc_topico.tipo = 9";
            $info = Migrantes::fetchArray($sql);

            $data = [];

            $i = 1;
            foreach ($info as $key) {
                $id = $key['id'];
                $lugar = $key['lugar'];
                $fecha = $key['fecha'];
                $municipio = trim($key['departamento']);
                $topico = $key['topico'];
                $tipo = $key['tipo'];
                $nacionalidad = $key['pais'];
                $edad = $key['edad'];
                $cantidad = number_format($key['cantidad']);





                $arrayInterno = [[
                    "contador" => $i,
                    "id" => $id,
                    "lugar" => $lugar,
                    "fecha" => $fecha,
                    "departamento" => $municipio,
                    "topico" => $topico,
                    "tipo" => $tipo,
                    "nacionalidad" => $nacionalidad,
                    "edad" => $edad,
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


    public function modalAPI()
    {
        getHeadersApi();



        try {


            $id = $_POST['id'];
            $sql = "SELECT amc_topico.id, fecha, lugar, departamento, municipio as muni, tipo,latitud,longitud,actividad, amc_topico.situacion, depmun.dm_desc_lg as departamento1, amc_actividad_vinculada.desc as act, amc_tipo_topics.desc as topico from amc_topico inner join depmun on amc_topico.departamento = depmun.dm_codigo inner join amc_actividad_vinculada on amc_topico.actividad = amc_actividad_vinculada.id inner join amc_tipo_topics on amc_topico.tipo = amc_tipo_topics.id where amc_topico.situacion = 1 and amc_topico.id =  $id";

            $info = Migrantes::fetchArray($sql);
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

                $actividad = $key['act'];


                if ($depto1 < 1000) {

                    $depto1 = '0' . $depto1;
                }



                $municipio = Migrantes::fetchArray("SELECT dm_desc_lg from depmun where dm_codigo = $muni");



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

                    "actividad" => $actividad,

                ]];
                $i++;
                $data = array_merge($data, $arrayInterno);
            }

            echo json_encode($data);
            // exit;

        } catch (Exception $e) {
            echo json_encode([
                "detalle" => $e->getMessage(),
                "mensaje" => "ocurrio un error en base de datos",

                "codigo" => 4,
            ]);
        }
    }

    function tipos_de_edades()
    {

        $sentencia = "SELECT * from amc_edades where situacion = 1";
        $result =  Migrantes::fetchArray($sentencia);
        return $result;
    }

    public function informacionMigrantesModalAPI()
    {
        getHeadersApi();

        // echo json_encode($sql);

        try {

            $id = $_POST['id'];

            $sql = "   SELECT amc_migrantes.id, amc_migrantes.topic as topico,  paises.pai_desc_lg as pais, amc_sexo.desc as sexo,  amc_edades.edades as edad, amc_migrantes.destino, amc_migrantes.cantidad   from amc_migrantes inner join paises on paises.pai_codigo = amc_migrantes.pais_migrante inner join amc_edades on amc_migrantes.edad = amc_edades.id inner join amc_sexo on amc_sexo.id = amc_migrantes.sexo where topic = $id and amc_migrantes.situacion = 1
";
            $info = Migrantes::fetchArray($sql);
            $data = [];

            $i = 1;
            foreach ($info as $key) {
                $id = $key['id'];
                $sexo = $key['sexo'];
                $pais = $key['pais'];
                $topico = $key['topico'];
                $destino = $key['destino'];
                $edad = $key['edad'];
                $cantidad = $key['cantidad'];

                $sql1 = "SELECT pai_desc_lg as destino from paises where pai_codigo = '$destino' ";

                $destino = Migrantes::fetchArray($sql1);

                if ($destino[0]['destino'] == null) {

                    $destino[0]['destino'] = "sin registros";
                }





                $arrayInterno = [[
                    "contador" => $i,
                    "id" => $id,
                    "sexo" => $sexo,
                    "pais" => $pais,
                    "topico" => $topico,
                    "destino" => $destino[0]['destino'],
                    "edad" => $edad,
                    "cantidad" => $cantidad,




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



    public function mapaCalorAPI()
    {
        getHeadersApi();

        // echo json_encode($sql);

        try {
            $edades = $_POST['edades_mapa_calor'];
            $fecha1 = str_replace('T', ' ', $_POST['fecha_mapa']);
            $fecha2 = str_replace('T', ' ', $_POST['fecha2']);



            $sql = "SELECT distinct dm_desc_lg as descripcion, dm_codigo as codigo, sum (cantidad ) as cantidad FROM amc_topico inner join depmun on departamento = dm_codigo  inner join amc_migrantes on topic = amc_topico.id  where 1 = 1  and amc_topico.situacion = 1 and amc_migrantes.situacion = 1 ";
            if ($edades != '') {

                $sql .= " AND amc_migrantes.edad = $edades";
            }
            if ($fecha1 != '' && $fecha2 == '') {

                $sql .= " AND amc_topico.fecha = '$fecha1'";
            }
            if ($fecha1 != '' && $fecha2 != '') {
                $sql .= " AND amc_topico.fecha   BETWEEN '$fecha1' AND  '$fecha2' ";
            }
            if ($fecha1 == '' && $fecha2 == '') {
                $sql .= " AND year(amc_topico.fecha) = year(current)  AND month(amc_topico.fecha) = month(current) ";
            }
            $sql .= " group by descripcion, codigo ";

            $info = Migrantes::fetchArray($sql);
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
            $sql = "SELECT * from amc_colores where topico = 9 and situacion = 1 order by nivel asc ";
            $info = Migrantes::fetchArray($sql);
            echo json_encode($info);
        } catch (Exception $e) {
            return [];
        }
    }

    public function coloresAPI1()
    {

        try {
            $sql = "SELECT * from amc_colores where topico = 9  ";
            $info = Migrantes::fetchArray($sql);
            return $info;
        } catch (Exception $e) {
            return [];
        }
    }

    public function mapaCalorDeptoAPI()
    {
        try {


            $depto = $_POST['departamento'];
            $edad = $_POST['edades_mapa_calor'];
            $fecha1 = str_replace('T', ' ', $_POST['fecha_mapa']);
            $fecha2 = str_replace('T', ' ', $_POST['fecha2']);
            // echo json_encode($_POST);
            // exit;
            $sql ="  SELECT  sum (cantidad ) as cantidad from amc_migrantes inner join amc_topico on amc_migrantes.topic = amc_topico.id  where  amc_topico.situacion = 1 and amc_migrantes.situacion = 1 AND amc_topico.departamento = $depto  ";

            if($edad != ''){
         
               $sql.= " AND amc_migrantes.edad = $edad";
            }
         
            if($fecha1 != '' && $fecha2 != ''){
         
               $sql.= " AND amc_topico.fecha   BETWEEN '$fecha1' AND  '$fecha2' ";
            }else{
         
               $sql.= " AND year(amc_topico.fecha) = year(current) AND month(amc_topico.fecha) = month(current)";
         
            }
         
         
            $info =  Migrantes::fetchArray($sql);
            
         
            if($info[0]['cantidad'] == ""){
     
               $info[0]['cantidad'] = 0;
            }
          
         
            $consulta="   SELECT first 1 amc_edades.edades , sum (cantidad ) as cantidad from amc_migrantes inner join amc_topico on amc_migrantes.topic = amc_topico.id inner join amc_edades on amc_migrantes.edad = amc_edades.id  where  amc_topico.situacion = 1 and amc_migrantes.situacion > 0  AND amc_topico.departamento = $depto ";
         
            if($edad != ''){
         
               $consulta.="AND amc_migrantes.edad = $edad";
            }
         
            if($fecha1 != '' && $fecha2 != ''){
         
               $consulta.= " AND amc_topico.fecha   BETWEEN '$fecha1' AND  '$fecha2' ";
            }else{
         
               $consulta.= " AND  year(amc_topico.fecha) = year(current) and month(amc_topico.fecha) = month(current)";
            }
         
            $consulta.="group by edades";
         
            $info1 =  Migrantes::fetchArray($consulta);
         
           
            if($info1[0]['cantidad'] == ""){
         
               $info1[0]['edades'] = 'Sin registros';
            }
         
            
            
            $array_resultante= array_merge($info,$info1);
            echo json_encode($array_resultante);
         
        } catch (Exception $e) {
            echo json_encode([
                "detalle" => $e->getMessage(),
                "mensaje" => "ocurrio un error en base de datos",

                "codigo" => 4,
            ]);
        }
    }


    public function mapaCalorPorDeptoGraficaAPI()
    {
        try {


            $depto = $_POST['departamento'];
            $edad = $_POST['edades_mapa_calor'];
            $fecha1 = str_replace('T', ' ', $_POST['fecha_mapa']);
            $fecha2 = str_replace('T', ' ', $_POST['fecha2']);
            // echo json_encode($_POST);
            // exit;

            $sql ="SELECT amc_edades.edades , sum (cantidad ) as cantidad from amc_migrantes inner join amc_topico on amc_migrantes.topic = amc_topico.id inner join amc_edades on amc_migrantes.edad = amc_edades.id  where   amc_topico.situacion = 1 and amc_migrantes.situacion > 0 ";
   
   
            if($depto != ''){
         
               $sql.=" AND amc_topico.departamento = $depto ";
            }
            if($edad != ''){
         
               $sql.=" AND amc_migrantes.edad = $edad";
            }
         
            if($fecha1 != '' && $fecha2 != ''){
         
               $sql.= " AND amc_topico.fecha   BETWEEN '$fecha1' AND  '$fecha2' ";
            }else{
         
                  $sql.="AND year(amc_topico.fecha) = year(current) and month(amc_topico.fecha) = month(current) ";
         
            }
         
            $sql.=" group by edades ";
                 
            $info = Migrantes::fetchArray($sql);

            

                echo json_encode($info );
               
        } catch (Exception $e) {
            echo json_encode([
                "detalle" => $e->getMessage(),
                "mensaje" => "ocurrio un error en base de datos",

                "codigo" => 4,
            ]);
        }
    }
}
