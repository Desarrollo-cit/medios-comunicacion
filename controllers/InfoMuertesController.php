<?php

namespace Controllers;

use Exception;
use Model\Capturadas;
use Model\Muertes;
use Model\Delito;
use Model\DepMun;
// use Model\Delito;
use MVC\Router;

class InfoMuertesController
{

    public function index(Router $router)
    {
        $capturas = static::cantidadCapturas();
        $mujeres = static::mujeres();
        $hombres = static::hombres();
        $depto = static::departamento_capturas();
        $delito = static::delitoIncurrente();
        $colores = static::coloresAPI1();
        $delitos = static::delitosApi();
        $router->render('mapas/muertes', [
            'capturas' => $capturas,
            'delito' => $delito,
            'delitos' => $delitos,
            'mujeres' => $mujeres,
            'hombres' => $hombres,
            'depto' => $depto,
            'colores' => $colores,
        ]);
    }


    protected static function cantidadCapturas($fecha1 = "", $fecha2 = "")
    {


        $sql = " SELECT  count (*) as cantidad from amc_per_asesinadas inner join amc_topico on amc_per_asesinadas.topico = amc_topico.id  where   amc_topico.situacion = 1 and amc_per_asesinadas.situacion >0";

        if($fecha1 != '' && $fecha2 != ''){

            $sql.= " AND amc_topico.fecha   BETWEEN '$fecha1' AND  '$fecha2' ";
         }else{
      
            $sql.=" AND year(amc_topico.fecha) = year(current)  and  month(amc_topico.fecha) = month(current) ";
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

    protected static function delitoIncurrente($fecha1 = "", $fecha2 = "")
    {


        $sql = "SELECT first 1  amc_per_asesinadas.situacion as delito, count(*) as cantidad from amc_per_asesinadas 
        inner join amc_topico on amc_per_asesinadas.topico = amc_topico.id   
        where     amc_topico.situacion = 1 and amc_per_asesinadas.situacion > 0  ";

        if($fecha1 != '' && $fecha2 != ''){

            $sql.= " AND amc_topico.fecha   BETWEEN '$fecha1' AND  '$fecha2' ";
         }else{
      
            $sql.=" AND year(amc_topico.fecha) = year(current)  and  month(amc_topico.fecha) = month(current) ";
         }

        $sql .= " group by delito order by cantidad desc";
        $result = Muertes::fetchArray($sql);

        if ($result) {

            if($result[0]['delito'] == 1){
                $result=[[
                    'desc' => "ASESINATO"]];
                    return $result;
                    exit;
            }
            if($result[0]['delito'] == 2){
                $result=[[
                    'desc' => "HOMICIDIO"]];
                    return $result;
                    exit;
            }
            if($result[0]['delito'] == 3){
                $result=[[
                    'desc' => "SICARIATO"]];
                    return $result;
                    exit;
            }
            if($result[0]['delito'] == 4){
                $result=[[
                    'desc' => "FEMICIDIO"]];
                    return $result;
                    exit;
            }
            if($result[0]['delito'] == 5){
                $result=[[
                    'desc' => "SUICIDIO"]];
                    return $result;
                    exit;
            }
           


            //return $result;
        } else {
            $delito = [[
                'desc' => "Sin datos"
            ]];
            return $delito;
        }
    }

    protected static function mujeres($fecha1 = "", $fecha2 = "")
    {


        $sql = "SELECT  count(*) as cantidad from amc_per_asesinadas inner join amc_topico on amc_per_asesinadas.topico = amc_topico.id 
        where   amc_topico.situacion = 1 and amc_per_asesinadas.sexo = 2 
        and amc_per_asesinadas.situacion > 0 ";


        if($fecha1 != '' && $fecha2 != ''){

            $sql.= " AND amc_topico.fecha   BETWEEN '$fecha1' AND  '$fecha2' ";
         }else{
      
            $sql.=" AND year(amc_topico.fecha) = year(current)  and  month(amc_topico.fecha) = month(current) ";
         }
        $result = Muertes::fetchArray($sql);
        if ($result) {
            return $result;
        } else {

            $delito = array("cantidad" => "Sin datos");
            return $delito;
        }
    }

    protected static function hombres($fecha1 = "", $fecha2 = "")
    {
        $sql = "SELECT count(*) as cantidad1 from amc_per_asesinadas inner join amc_topico on amc_per_asesinadas.topico = amc_topico.id   where   amc_topico.situacion = 1 and sexo = 1 and amc_per_asesinadas.situacion > 0";



        if($fecha1 != '' && $fecha2 != ''){

            $sql.= " AND amc_topico.fecha   BETWEEN '$fecha1' AND  '$fecha2' ";
         }else{
      
            $sql.=" AND year(amc_topico.fecha) = year(current)  and  month(amc_topico.fecha) = month(current) ";
         }
        $result = Muertes::fetchArray($sql);
        if ($result) {
            return $result;
        } else {

            $delito = array("CANTIDAD1" => "Sin datos");
            return $delito;
        }
    }


    protected static function departamento_capturas($fecha1 = "", $fecha2 = "")
    {
        $sql = "  SELECT FIRST 1 amc_topico.departamento as departamento, count(*) as cantidad FROM amc_topico 
        inner join amc_per_asesinadas on amc_topico.id = amc_per_asesinadas.topico 
        where year(amc_topico.fecha) = year(current) and amc_topico.situacion = 1
         and amc_per_asesinadas.situacion > 0  ";
        if($fecha1 != '' && $fecha2 != ''){

            $sql.= " AND amc_topico.fecha   BETWEEN '$fecha1' AND  '$fecha2' ";
         }else{
      
            $sql.=" AND year(amc_topico.fecha) = year(current)  and  month(amc_topico.fecha) = month(current) ";
         }

        $sql .= " group by departamento order by cantidad desc";



        $result1 = Capturadas::fetchArray($sql);

        if ($result1) {
            foreach ($result1 as $row) {

                $depto = trim($row['departamento']);
            }

            $sql = "SELECT dm_desc_lg as desc from depmun where dm_codigo = $depto ";
            $result1 = Capturadas::fetchArray($sql);
            return $result1;
        } else {

            $depto = [[
                'desc' => "Sin datos"
            ]];
            return $depto;
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
        
      

        $capturas = static::cantidadCapturas($fecha1, $fecha2);

        $delito = static::delitoIncurrente($fecha1, $fecha2);
        $mujeres = static::mujeres($fecha1, $fecha2);
        $hombres = static::hombres($fecha1, $fecha2);
        $depto = static::departamento_capturas($fecha1, $fecha2);
        $array_resultante = array_merge($capturas, $delito, $mujeres, $hombres, $depto);

     echo json_encode($array_resultante);
    }


    public function listadoAPI()
    {
        getHeadersApi();


        try {

            $sql = "   SELECT DISTINCT amc_topico.id as id, amc_topico.lugar as lugar, amc_per_asesinadas.situacion as tipo, amc_tipo_topics.desc as topico,
            amc_topico.fecha as fecha, dm_desc_lg as departamento,  
            amc_actividad_vinculada.desc as actividad from amc_topico inner join amc_per_asesinadas 
            on amc_per_asesinadas.topico = amc_topico.id  inner join amc_tipo_topics on amc_topico.tipo = amc_tipo_topics.id inner join depmun on amc_topico.departamento = depmun.dm_codigo 
             inner join amc_actividad_vinculada on amc_topico.actividad = amc_actividad_vinculada.id and amc_per_asesinadas.situacion > 0 and amc_topico.situacion = 1
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
                $situacion = $key['tipo'];
                $actividad = $key['actividad'];

                switch($tipo){

                    case "1":
              
              $tipo = "ASESINATO";
                       break;
                    case "2":
              
              $tipo = "HOMICIDIO";
                       break;
                    case "3":
              
              $tipo = "SICARIATO";
                       break;
                    case "4":
              
              $tipo = "FEMICIDIO";
                       break;
                    case "5":
              
              $tipo = "SUICIDIO";
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
            
            
            $sql = "SELECT amc_topico.id, fecha, lugar, departamento, municipio as muni, tipo,latitud,longitud,actividad, amc_topico.situacion, depmun.dm_desc_lg as departamento1, amc_actividad_vinculada.desc as act, amc_tipo_topics.desc as topico from amc_topico inner join depmun on amc_topico.departamento = depmun.dm_codigo inner join amc_actividad_vinculada on amc_topico.actividad = amc_actividad_vinculada.id inner join amc_tipo_topics on amc_topico.tipo = amc_tipo_topics.id where amc_topico.situacion = 1 and amc_topico.id =  $id";
            $info =Capturadas::fetchArray($sql);
            $data=[];
            
            
            $i=1;
            foreach($info as $key){ 
                 $id = $key['id'];
               $lugar = $key['lugar'];
               $fecha = $key['fecha'];
               $depto =trim( $key['departamento1']);
               $depto1 =trim( (string)$key['departamento']);
               $muni = $key['muni'];
               $latitud = $key['latitud'];
               $longitud = $key['longitud'];
               $tipo = $key['topico'];
             //  $delito = $key['delito'];
               $actividad = $key['act'];
            
            
               if($depto1 <1000){
            
                  $depto1 = '0'.$depto1;
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
               $data = array_merge($data,$arrayInterno);
               
              
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

            $sql = "SELECT amc_per_asesinadas.id, amc_per_asesinadas.topico,  amc_sexo.desc as sexo, amc_per_asesinadas.nombre, amc_per_asesinadas.situacion, amc_per_asesinadas.edad  from amc_per_asesinadas inner join amc_sexo on amc_sexo.id = amc_per_asesinadas.sexo  where topico = $id and amc_per_asesinadas.situacion > 0";
            $info = Capturadas::fetchArray($sql);
            $data=[];
            
            $i=1;
            foreach($info as $key){ 
               $id = $key['id'];
               $sexo = $key['sexo'];
               //$nacionalidad = utf8_encode($key['nacionalidad']);
               $nombre = utf8_encode($key['nombre']);
               $topico = $key['topico'];
              // $delito = utf8_encode($key['delito']);
               $edad = $key['edad'];
               
            
               
            
               
                $arrayInterno = [[
                   "contador" => $i,
                   "id" => $id,
                   "sexo" => $sexo,
                   //"nacionalidad" => $nacionalidad,
                   "nombre" => $nombre,
                   "topico" => $topico,
                  // "delito" => $delito,
                   "edad" => $edad,
                
                 
                 
                  
               ]];
               $i++;
               $data = array_merge($data,$arrayInterno);
            
            
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
    public function informacionModalAPI1()
    {
        getHeadersApi();
       
        // echo json_encode($sql);

        try {

            $id = $_POST['id'];

            $sql = "SELECT amc_incautacion_droga.cantidad as cantidad, amc_incautacion_droga.tipo_transporte as tipo_t, amc_incautacion_droga.id, amc_incautacion_droga.tipo_droga, matricula, amc_drogas.desc as droga, amc_transporte.desc as transporte   from amc_incautacion_droga inner join amc_drogas on amc_incautacion_droga.tipo_droga = amc_drogas.id inner join amc_transporte on amc_incautacion_droga.transporte = amc_transporte.id where amc_incautacion_droga.topico =$id and  amc_incautacion_droga.situacion = 1";
            $info =Capturadas::fetchArray($sql);
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
            $muerte = $_POST['tipos_muerte_mapa_calor'];
            $fecha1 = str_replace('T', ' ', $_POST['fecha_mapa']);
            $fecha2 = str_replace('T', ' ', $_POST['fecha2']);
         
         
            $sql ="       SELECT distinct dm_desc_lg as descripcion, dm_codigo as codigo, count (*) as cantidad FROM amc_topico 
            inner join depmun on departamento = dm_codigo 
            inner join amc_per_asesinadas on topico = amc_topico.id  
            where 1 = 1  and amc_topico.situacion = 1 and amc_per_asesinadas.situacion > 0 ";
            if($muerte != ''){
         
               $sql.= "AND amc_per_asesinadas.situacion = $muerte";
            }
            if($fecha1 != '' && $fecha2 == ''){
         
               $sql.= "AND amc_topico.fecha = '$fecha1'";
            }
            if($fecha1 != '' && $fecha2 != ''){
               $sql.= " AND amc_topico.fecha   BETWEEN '$fecha1' AND  '$fecha2' ";
           }
           if($fecha1 == '' && $fecha2 == ''){
            $sql.= " AND year(fecha) = year(current) AND month(fecha) = month(current)  ";
         }
            $sql.=" group by descripcion, codigo ";
         
            $info = Capturadas::fetchArray($sql);
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
            $sql = "SELECT * from amc_colores where topico = 1 and situacion = 1 order by nivel asc ";
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
            $muerte = $_POST['tipos_muerte_mapa_calor'];
            $fecha1 = str_replace('T', ' ', $_POST['fecha_mapa']);
            $fecha2 = str_replace('T', ' ', $_POST['fecha2']);


            $sql ="  SELECT  count (*) as cantidad_delito from amc_per_asesinadas inner join amc_topico on amc_per_asesinadas.topico = amc_topico.id  where  amc_topico.situacion = 1 and amc_per_asesinadas.situacion > 0 AND amc_topico.departamento = $depto  ";
         
            if($muerte != ''){
         
               $sql.= " AND amc_per_asesinadas.situacion = $muerte";
            }
         
            if($fecha1 != '' && $fecha2 != ''){
         
               $sql.= " AND amc_topico.fecha   BETWEEN '$fecha1' AND  '$fecha2' ";
            }else {
         
               $sql.= " AND year(amc_topico.fecha) = year(current) and  month(amc_topico.fecha) = month(current)";
            }
           
            $info = Capturadas::fetchArray($sql);
            
         
            $consulta="      SELECT FIRST 1 amc_per_asesinadas.situacion, count(*) as cantidad_max FROM amc_per_asesinadas inner join amc_topico on amc_per_asesinadas.topico = amc_topico.id  
            where   amc_topico.situacion = 1 and amc_per_asesinadas.situacion > 0 AND amc_topico.departamento = $depto";
         
            if($muerte != ''){
         
               $consulta.="AND amc_per_asesinadas.situacion = $muerte";
            }
         
            if($fecha1 != '' && $fecha2 != ''){
         
               $consulta.= " AND amc_topico.fecha   BETWEEN '$fecha1' AND  '$fecha2' ";
            }else {
         
               $consulta.= " AND year(amc_topico.fecha) = year(current) and  month(amc_topico.fecha) = month(current)";
            }
         
            $consulta.="   group by situacion ORDER by cantidad_max desc";
         
            $info1 = Capturadas::fetchArray($consulta);
            if ($info1) {
             
                $array_resultante = array_merge($info, $info1);
                echo json_encode($array_resultante);
            } else {

                $info1[1] = [
                    "desc" => "sin registros",
                    "cantidad_max" => 0
                ];
                $array_resultante = array_merge($info, $info1);
                echo json_encode($array_resultante);
            }
   
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
            $sql = "SELECT * from amc_colores where topico = 1  ";
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
            $muerte = $_POST['tipos_muerte_mapa_calor'];
            $fecha1 = str_replace('T', ' ', $_POST['fecha_mapa']);
            $fecha2 = str_replace('T', ' ', $_POST['fecha2']);
            // echo json_encode($_POST);
            // exit;

            $sql = "SELECT amc_per_asesinadas.situacion as descripcion, count(*) as cantidad FROM amc_per_asesinadas  inner join amc_topico on amc_per_asesinadas.topico = amc_topico.id where  amc_topico.situacion = 1 and amc_per_asesinadas.situacion > 0 ";


            if ($depto != '') {

                $sql .= "AND amc_topico.departamento = $depto ";
            }
            if ($muerte != '') {

                $sql .= "AND amc_per_asesinadas.delito = $muerte";
            }

            if ($fecha1 != '' && $fecha2 != '') {

                $sql .= " AND amc_topico.fecha   BETWEEN '$fecha1' AND  '$fecha2' ";
            } else {

                $sql .= " AND year(amc_topico.fecha) = year(current)  and  month(amc_topico.fecha) = month(current) ";
            }

            $sql .= " group by descripcion ";
            $info = Capturadas::fetchArray($sql);

            

                echo json_encode($info ? $info:[]);
               
        } catch (Exception $e) {
            echo json_encode([
                "detalle" => $e->getMessage(),
                "mensaje" => "ocurrio un error en base de datos",

                "codigo" => 4,
            ]);
        }
    }






}



