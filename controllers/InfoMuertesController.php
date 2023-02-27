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
            $sql = "SELECT * from amc_colores where topico = 2 and situacion = 1 order by nivel asc ";
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
            $sql = "SELECT * from amc_colores where topico = 2  ";
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


//// PARTE DE LAS GRAFICAS 
    

    public function DelitosCantGraficaAPI()
    {
        try {


       
            $fecha1 = str_replace('T', ' ', $_POST['fecha_grafica']);
            $fecha2 = str_replace('T', ' ', $_POST['fecha_grafica2']);

            $sql = "SELECT amc_per_asesinadas.situacion as descripcion, count(*) as cantidad FROM amc_per_asesinadas  inner join amc_topico on amc_per_asesinadas.topico = amc_topico.id where  amc_topico.situacion = 1 and amc_per_asesinadas.situacion > 0";


      

            if ($fecha1 != '' && $fecha2 != '') {

                $sql .= " AND amc_topico.fecha   BETWEEN '$fecha1' AND  '$fecha2' ";
            } else {

                $sql .= " AND year(amc_topico.fecha) = year(current)  and  month(amc_topico.fecha) = month(current) ";
            }




            $sql .= " group by descripcion ";
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



    
    public function CapturasPorDiaGraficaAPI()
    {
        try {


            $diasMes =  date('t');
            $data = [];
            for ($i = 0; $i <=  $diasMes; $i++) {
                // $main = new Main();
                $sql = "SELECT count(*) as  cantidad  From amc_per_asesinadas inner join amc_topico on amc_per_asesinadas.topico = amc_topico.id where month(amc_topico.fecha) = month(current) and day(amc_topico.fecha) = day($i) and amc_topico.situacion = 1 and amc_per_asesinadas.situacion > 0";
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
            $labels = [];
            $cantidades = [];
            $i = 0;
            $a = 0;
            for ($a = 1; $a <= 5 ; $a++  ) {
      
                $tipo_id = $a;
         
                switch($a){
                case"1":
                $labels[]= "ASESINATO";
                break;
                case"2":
                $labels[]= "HOMICIDIO";
                break;
                case"3":
                $labels[]= "SICARIATO";
                break;
                case"4":
                $labels[]= "FEMICIDIO";
                break;
                case"5":
                $labels[]= "SUICIDIO";
                break;
                }

                for($i = 0 ; $i < 3 ; $i++){
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
                $sql = " SELECT  count (*) as cantidad from amc_per_asesinadas inner join amc_topico on amc_per_asesinadas.topico = amc_topico.id  where month(amc_topico.fecha) = $mes_en_query and amc_topico.situacion = 1 and amc_per_asesinadas.situacion > 0";

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

        $sentencia = "select count(*) as  cantidad  from amc_per_asesinadas inner join amc_topico on amc_per_asesinadas.topico = amc_topico.id where month(amc_topico.fecha) = $mes  and amc_topico.situacion = 1 and amc_per_asesinadas.situacion = $delito";
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



            $sql = "   SELECT depmun.dm_desc_lg as descripcion, count(*) as cantidad FROM amc_per_asesinadas   inner join amc_topico on amc_per_asesinadas.topico = amc_topico.id inner join depmun on amc_topico.departamento = depmun.dm_codigo
            where amc_topico.situacion = 1 and amc_per_asesinadas.situacion > 0 ";


           

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



}




