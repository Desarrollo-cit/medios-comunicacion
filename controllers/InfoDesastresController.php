<?php

namespace Controllers;

use Exception;
use DateTime;
use Model\Des_natural;

use Model\DepMun;
// use Model\Delito;
use MVC\Router;

class InfoDesastresController
{
    public function index(Router $router)
    {
        $fenomeno_natural = static::fenomeno_natural();
        $cantidadDesastres = static::cantidadDesastres();
        $totalPersonasEvacuadas = static::totalPersonasEvacuadas();
        $IncidenciaDesastre = static::IncidenciaDesastre();
        $totalPersonaAfectada = static::totalPersonaAfectada();
    
        $totalPersonasFallecida = static::totalPersonasFallecida();
        $EstructuraColapsada = static::EstructuraColapsada();
        $Inundaciones = static::Inundaciones();
        $Derrumbes = static::Derrumbes();
        $CarreterasyPuentes = static::CarreterasyPuentes();
        $hectareasQuemadas = static::hectareasQuemadas();
        $DesbordamientosRios = static::DesbordamientosRios();
        $departamentoAfectado = static::departamentoAfectado();

        $colores = static::coloresAPI1();

        $router->render('mapas/desastres', [
            'fenomeno_natural' => $fenomeno_natural,
            'cantidadDesastres' => $cantidadDesastres,
            'totalPersonasEvacuadas' => $totalPersonasEvacuadas,
            'IncidenciaDesastre' => $IncidenciaDesastre,
            'totalPersonaAfectada' => $totalPersonaAfectada,
         
            'totalPersonasFallecida' => $totalPersonasFallecida,
            'EstructuraColapsada' => $EstructuraColapsada,
            'Inundaciones' => $Inundaciones,
            'Derrumbes' => $Derrumbes,
            'CarreterasyPuentes' => $CarreterasyPuentes,
            'hectareasQuemadas' => $hectareasQuemadas,
            'DesbordamientosRios' => $DesbordamientosRios,
            'departamentoAfectado' => $departamentoAfectado,
            'colores' => $colores,

        ]);
    }

    static function  fenomeno_natural()
    {

        $sentencia = "SELECT * from amc_fenomeno_natural where situacion = 1";
        $result = Des_natural::fetchArray($sentencia);
        return $result;
    }

    static public function coloresAPI()
    {
        getHeadersApi();
        try {
            $sql = "SELECT * from amc_colores where topico = 4 and situacion = 1 order by nivel asc ";
            $info = Des_natural::fetchArray($sql);
            echo json_encode($info);
        } catch (Exception $e) {
            return [];
        }
    }

    static public function coloresAPI1()
    {

        try {
            $sql = "SELECT * from amc_colores where topico = 4  ";
            $info = Des_natural::fetchArray($sql);
            return $info;
        } catch (Exception $e) {
            return [];
        }
    }
    protected static function cantidadDesastres($fecha1 = "", $fecha2 = "")
    {


        $sql = " SELECT  count (*) as cantidad from amc_desastre_natural 
        inner join amc_topico on amc_desastre_natural.topico = amc_topico.id 
        where  amc_topico.situacion = 1 and amc_desastre_natural.situacion = 1";

        if ($fecha1 != '' && $fecha2 != '') {

            $sql .= " AND amc_topico.fecha   BETWEEN '$fecha1' AND  '$fecha2' ";
        } else {

            $sql .= " AND year(amc_topico.fecha) = year(current)  and  month(amc_topico.fecha) = month(current) ";
        }
        $result = Des_natural::fetchArray($sql);
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


    static function totalPersonasEvacuadas($fecha1 = "", $fecha2 = "",  $fenomeno = "")
    {


        $sql = "SELECT  sum(amc_desastre_natural.per_evacuada) as cantidad from amc_desastre_natural inner join amc_topico on amc_desastre_natural.topico = amc_topico.id  where  amc_desastre_natural.situacion = 1 ";



        if ($fecha1 == '' && $fecha2 == '') {

            $sql .= " AND year(amc_topico.fecha) = year(current) and month(amc_topico.fecha) = month(current) ";
        }

        if ($fenomeno != ''   ) {

            $sql .= " AND amc_desastre_natural.nombre_desastre = $fenomeno";
        }
       

        if ($fecha1 != '' && $fecha2 != '' ) {

            $sql .= " AND amc_topico.fecha   BETWEEN '$fecha1' AND  '$fecha2' ";
        }
        
        $result = Des_natural::fetchArray($sql);
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


    static function totalPersonasFallecida($fecha1 = "", $fecha2 = "",  $fenomeno = "")
    {


        $sql = "SELECT  sum(amc_desastre_natural.per_fallecida) as cantidad from amc_desastre_natural inner join amc_topico on amc_desastre_natural.topico = amc_topico.id  where  amc_desastre_natural.situacion = 1 ";

        if ($fecha1 == '' && $fecha2 == '') {

            $sql .= " AND year(amc_topico.fecha) = year(current) and month(amc_topico.fecha) = month(current) ";
        }

        if ($fenomeno != '' ) {

            $sql .= " AND amc_desastre_natural.nombre_desastre = $fenomeno";
        }
       

        if ($fecha1 != '' && $fecha2 != '') {

            $sql .= " AND amc_topico.fecha   BETWEEN '$fecha1' AND  '$fecha2' ";
        }
        $result = Des_natural::fetchArray($sql);
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


    static function IncidenciaDesastre($fecha1 = "", $fecha2 = "")
    {


        $sql = "  SELECT FIRST 1  amc_tipo_desastre_natural.desc, count(amc_tipo_desastre_natural.desc) as cantidad from amc_desastre_natural inner join amc_tipo_desastre_natural on amc_desastre_natural.tipo = amc_tipo_desastre_natural.id inner join amc_topico on amc_desastre_natural.topico = amc_topico.id  where  amc_desastre_natural.situacion = 1 and amc_topico.situacion = 1";

        if ($fecha1 == '' && $fecha2 == '') {

            $sql .= " AND  year(amc_topico.fecha) = year(current) and month(amc_topico.fecha) = month(current) ";
        }

      
       

        if ($fecha1 != '' && $fecha2 != '') {

            $sql .= " AND amc_topico.fecha   BETWEEN '$fecha1' AND  '$fecha2' ";
        }

        $sql .= " group by  desc order by desc asc";
        $result = Des_natural::fetchArray($sql);
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

    static function totalPersonaAfectada($fecha1 = "", $fecha2 = "",   $fenomeno = "")
    {


        $sql = "SELECT  sum(amc_desastre_natural.per_afectada) as cantidad from amc_desastre_natural inner join amc_topico on amc_desastre_natural.topico = amc_topico.id  where  amc_desastre_natural.situacion = 1 ";

        if ($fecha1 == '' && $fecha2 == '' && $fenomeno =="") {

            $sql .= " AND year(amc_topico.fecha) = year(current) and month(amc_topico.fecha) = month(current) ";
        }

        if ($fenomeno != '' ) {

            $sql .= " AND amc_desastre_natural.nombre_desastre = $fenomeno";
        }
       

        if ($fecha1 != '' && $fecha2 != '') {

            $sql .= " AND amc_topico.fecha   BETWEEN '$fecha1' AND  '$fecha2' ";
        }
        $result = Des_natural::fetchArray($sql);
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

  
    static function EstructuraColapsada($fecha1 = "", $fecha2 = "",  $fenomeno = "")
    {


        $sql = "SELECT  sum(amc_desastre_natural.est_colapsadas) as cantidad from amc_desastre_natural inner join amc_topico on amc_desastre_natural.topico = amc_topico.id  where amc_desastre_natural.situacion = 1 ";

        if ($fecha1 == '' && $fecha2 == '' && $fenomeno =="") {

            $sql .= " AND year(amc_topico.fecha) = year(current) and month(amc_topico.fecha) = month(current) ";
        }

        if ($fenomeno != '' ) {

            $sql .= " AND amc_desastre_natural.nombre_desastre = $fenomeno";
        }
       

        if ($fecha1 != '' && $fecha2 != '') {

            $sql .= " AND amc_topico.fecha   BETWEEN '$fecha1' AND  '$fecha2' ";
        }
        $result = Des_natural::fetchArray($sql);
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

    static function Inundaciones($fecha1 = "", $fecha2 = "",  $fenomeno = "")
    {


        $sql = "SELECT  sum(amc_desastre_natural.inundaciones) as cantidad from amc_desastre_natural inner join amc_topico on amc_desastre_natural.topico = amc_topico.id  where  amc_desastre_natural.situacion = 1 ";

        if ($fecha1 == '' && $fecha2 == ''&& $fenomeno =="") {

            $sql .= " AND year(amc_topico.fecha) = year(current) and month(amc_topico.fecha) = month(current) ";
        }

        if ($fenomeno != '' ) {

            $sql .= " AND amc_desastre_natural.nombre_desastre = $fenomeno";
        }
       

        if ($fecha1 != '' && $fecha2 != '') {

            $sql .= " AND amc_topico.fecha   BETWEEN '$fecha1' AND  '$fecha2' ";
        }
        $result = Des_natural::fetchArray($sql);
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


    static function Derrumbes($fecha1 = "", $fecha2 = "",  $fenomeno = "")
    {


        $sql = "SELECT  sum(amc_desastre_natural.derrumbes) as cantidad from amc_desastre_natural inner join amc_topico on amc_desastre_natural.topico = amc_topico.id  where  amc_desastre_natural.situacion = 1 ";

        if ($fecha1 == '' && $fecha2 == ''&& $fenomeno =="") {

            $sql .= " AND year(amc_topico.fecha) = year(current) and month(amc_topico.fecha) = month(current) ";
        }

        if ($fenomeno != '' ) {

            $sql .= " AND amc_desastre_natural.nombre_desastre = $fenomeno";
        }
       

        if ($fecha1 != '' && $fecha2 != '') {

            $sql .= " AND amc_topico.fecha   BETWEEN '$fecha1' AND  '$fecha2' ";
        }
        $result = Des_natural::fetchArray($sql);
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


    static function CarreterasyPuentes($fecha1 = "", $fecha2 = "",  $fenomeno = "")
    {


        $sql = "SELECT  sum(amc_desastre_natural.carre_colap) as cantidad from amc_desastre_natural inner join amc_topico on amc_desastre_natural.topico = amc_topico.id  where  amc_desastre_natural.situacion = 1 ";

        if ($fecha1 == '' && $fecha2 == '' && $fenomeno =="") {

            $sql .= " AND year(amc_topico.fecha) = year(current) and month(amc_topico.fecha) = month(current) ";
        }

        if ($fenomeno != '' ) {

            $sql .= " AND amc_desastre_natural.nombre_desastre = $fenomeno";
        }
       

        if ($fecha1 != '' && $fecha2 != '') {

            $sql .= " AND amc_topico.fecha   BETWEEN '$fecha1' AND  '$fecha2' ";
        }
        $result = Des_natural::fetchArray($sql);
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


    static function hectareasQuemadas($fecha1 = "", $fecha2 = "",  $fenomeno = "")
    {


        $sql = "SELECT  sum(amc_desastre_natural.hectareas_quemadas) as cantidad from amc_desastre_natural inner join amc_topico on amc_desastre_natural.topico = amc_topico.id  where  amc_desastre_natural.situacion = 1 ";

        if ($fecha1 == '' && $fecha2 == '' && $fenomeno =="") {

            $sql .= " AND year(amc_topico.fecha) = year(current) and month(amc_topico.fecha) = month(current) ";
        }

        if ($fenomeno != '' ) {

            $sql .= " AND amc_desastre_natural.nombre_desastre = $fenomeno";
        }
       

        if ($fecha1 != '' && $fecha2 != '') {

            $sql .= " AND amc_topico.fecha   BETWEEN '$fecha1' AND  '$fecha2' ";
        }
        $result = Des_natural::fetchArray($sql);
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


    static function DesbordamientosRios($fecha1 = "", $fecha2 = "",  $fenomeno = "")
    {


        $sql = "SELECT  sum(amc_desastre_natural.rios) as cantidad from amc_desastre_natural inner join amc_topico on amc_desastre_natural.topico = amc_topico.id  where  amc_desastre_natural.situacion = 1 ";

        if ($fecha1 == '' && $fecha2 == '' && $fenomeno =="") {

            $sql .= " AND year(amc_topico.fecha) = year(current) and month(amc_topico.fecha) = month(current) ";
        }

        if ($fenomeno != '' ) {

            $sql .= " AND amc_desastre_natural.nombre_desastre = $fenomeno";
        }
       

        if ($fecha1 != '' && $fecha2 != '') {

            $sql .= " AND amc_topico.fecha   BETWEEN '$fecha1' AND  '$fecha2' ";
        }
        $result = Des_natural::fetchArray($sql);
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

    static function departamentoAfectado($fecha1 = "", $fecha2 = "",  $fenomeno = "")
    {


        $sql = " SELECT FIRST 1 amc_fenomeno_natural.desc as nombre, dm_desc_lg as departamento, (per_fallecida + per_evacuada + per_afectada + albergues + est_colapsadas + inundaciones + derrumbes + carre_colap + hectareas_quemadas + rios)/6 as promedio, per_fallecida + per_evacuada + per_afectada + albergues + est_colapsadas + inundaciones + derrumbes + carre_colap + hectareas_quemadas + rios as suma from amc_desastre_natural inner join amc_fenomeno_natural on nombre_desastre = amc_fenomeno_natural.id inner join amc_topico on amc_desastre_natural.topico = amc_topico.id inner join depmun on amc_topico.departamento = dm_codigo  where amc_topico.situacion = 1";

        if ($fecha1 == '' && $fecha2 == '' && $fenomeno =="") {

            $sql .= " AND year(amc_topico.fecha) = year(current) and month(amc_topico.fecha) = month(current) ";
        }

        if ($fenomeno != '' ) {

            $sql .= " AND amc_desastre_natural.nombre_desastre = $fenomeno";
        }
       

        if ($fecha1 != '' && $fecha2 != '') {

            $sql .= " AND amc_topico.fecha   BETWEEN '$fecha1' AND  '$fecha2' ";
        }

        $sql.= " order by promedio desc";
        $result = Des_natural::fetchArray($sql);
        if ($result[0]['suma'] != null) {
            return $result;
        } else {

            $result = [[
                "departamento" =>
                "Sin datos"
            ]];
            return $result;
        }
    }



  

    public function resumenAPI()
    {
        getHeadersApi();
        // echo json_encode($_POST) ;
        // exit;


        $fecha1 = $_POST['fecha_resumen'];
        $fecha2 = $_POST['fecha_resumen2'];
        $fenomeno = $_POST['fenomenos_naturales'];

        $fecha1 = str_replace('T', ' ', $fecha1);
        $fecha2 = str_replace('T', ' ', $fecha2);
       


        $cantidadDesastres = static::cantidadDesastres($fecha1, $fecha2);
        $totalPersonasEvacuadas = static::totalPersonasEvacuadas($fecha1, $fecha2,  $fenomeno);
        $IncidenciaDesastre = static::IncidenciaDesastre($fecha1, $fecha2);
        $totalPersonaAfectada = static::totalPersonaAfectada($fecha1, $fecha2,  $fenomeno);
        $totalPersonasFallecida = static::totalPersonasFallecida($fecha1, $fecha2,  $fenomeno);
        $EstructuraColapsada = static::EstructuraColapsada($fecha1, $fecha2,  $fenomeno);
        $Inundaciones = static::Inundaciones($fecha1, $fecha2,  $fenomeno);
        $Derrumbes = static::Derrumbes($fecha1, $fecha2,  $fenomeno);
        $CarreterasyPuentes = static::CarreterasyPuentes($fecha1, $fecha2,  $fenomeno);
        $hectareasQuemadas = static::hectareasQuemadas($fecha1, $fecha2,  $fenomeno);
        $DesbordamientosRios = static::DesbordamientosRios($fecha1, $fecha2,  $fenomeno);
        $departamentoAfectado = static::departamentoAfectado($fecha1, $fecha2,  $fenomeno);
      
        $array_resultante = array_merge($cantidadDesastres, $IncidenciaDesastre, $totalPersonasEvacuadas, $totalPersonaAfectada, $totalPersonasFallecida,  $EstructuraColapsada,  $Inundaciones, $Derrumbes, $CarreterasyPuentes, $hectareasQuemadas, $DesbordamientosRios, $departamentoAfectado);

        echo json_encode($array_resultante);
    }

    public function listadoAPI()
    {
        getHeadersApi();


        try {

            $sql = "SELECT amc_fenomeno_natural.desc as nombre, dm_desc_lg as departamento, per_fallecida  as muertes, (per_fallecida + per_evacuada + per_afectada + albergues + est_colapsadas + inundaciones + derrumbes + carre_colap + hectareas_quemadas + rios)/6 as promedio, per_fallecida + per_evacuada + per_afectada + albergues + est_colapsadas + inundaciones + derrumbes + carre_colap + hectareas_quemadas + rios as suma, amc_fenomeno_natural.id as idfenomeno, amc_fenomeno_natural.desc as fenomeno, amc_topico.id as id,    amc_topico.lugar as lugar,  amc_tipo_desastre_natural.desc as tipo,  amc_topico.fecha as fecha, amc_topico.tipo as tipoTopico, depmun.dm_desc_lg as departamento from amc_desastre_natural 
            inner join amc_fenomeno_natural on nombre_desastre = amc_fenomeno_natural.id
            inner join amc_topico on amc_desastre_natural.topico = amc_topico.id
            inner join amc_tipo_desastre_natural on amc_tipo_desastre_natural.id = amc_desastre_natural.tipo
            inner join depmun on amc_topico.departamento = dm_codigo 
            where amc_topico.situacion = 1 ";
            $info = Des_natural::fetchArray($sql);

            $data = [];

            $i = 1;
            foreach ($info as $key) {
                $id = $key['id'];
                $lugar = $key['lugar'];
                $fecha = $key['fecha'];
                $departamento = trim($key['departamento']);
                $fenomeno = $key['fenomeno'];
                $tipo = $key['tipo'];
                $tipoTopico = $key['tipoTopico'];
                $muertes = $key['muertes'];
                $promedio = round($key['promedio'],'2');
                


                $arrayInterno = [[
                    "contador" => $i,
                    "id" => $id,
                    "lugar" => $lugar,
                    "fecha" => $fecha,
                    "departamento" => $departamento,
                    "tipoTopico" => $tipoTopico,
                    "fenomeno" => $fenomeno,
                    "tipo" => $tipo,
                    "muertes" => $muertes,
                    "promedio" => $promedio,








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
            $info = Des_natural::fetchArray($sql);
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
            $info = Des_natural::fetchArray($sql);


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
            $info = Des_natural::fetchArray($sql);


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

            $info = Des_natural::fetchArray($sql);
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
            $info = Des_natural::fetchArray($sql);


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

            $info = Des_natural::fetchArray($sql);


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

                $info = Des_natural::fetchArray($sql);
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
            $fenomeno = $_POST['incautaciondroga_mapa_calor'];
            $fecha1 = str_replace('T', ' ', $_POST['fecha_mapa']);
            $fecha2 = str_replace('T', ' ', $_POST['fecha2']);


            $totalPersonasEvacuadas = static::totalPersonasEvacuadas($fecha1, $fecha2, $depto ="", $fenomeno);
            $IncidenciaDesastre = static::IncidenciaDesastre($fecha1, $fecha2, $depto ="", $fenomeno);
            $totalPersonaAfectada = static::totalPersonaAfectada($fecha1, $fecha2, $depto ="", $fenomeno);
            $totalPersonasFallecida = static::totalPersonasFallecida($fecha1, $fecha2, $depto ="", $fenomeno);
            $EstructuraColapsada = static::EstructuraColapsada($fecha1, $fecha2, $depto ="", $fenomeno);
            $Inundaciones = static::Inundaciones($fecha1, $fecha2, $depto ="", $fenomeno);
            $Derrumbes = static::Derrumbes($fecha1, $fecha2, $depto ="", $fenomeno);
            $CarreterasyPuentes = static::CarreterasyPuentes($fecha1, $fecha2, $depto ="", $fenomeno);
            $hectareasQuemadas = static::hectareasQuemadas($fecha1, $fecha2, $depto ="", $fenomeno);
            $DesbordamientosRios = static::DesbordamientosRios($fecha1, $fecha2, $depto ="", $fenomeno);
          
            $array_resultante = array_merge( $IncidenciaDesastre, $totalPersonasEvacuadas, $totalPersonaAfectada, $totalPersonasFallecida,  $EstructuraColapsada,  $Inundaciones, $Derrumbes, $CarreterasyPuentes, $hectareasQuemadas, $DesbordamientosRios);

            echo json_encode($array_resultante);
        } catch (Exception $e) {
            return [];
        }
    }

    function departamental_grafica($mes, $fecha1, $fecha2, $depto, $droga)
    {

        if ($mes == 13) {
            return static::totalPersonasEvacuadas($fecha1, $fecha2, $depto, $droga);
        }
        if ($mes == 14) {
            return static::totalPersonaAfectada($fecha1, $fecha2, $depto, $droga);
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


            $tipos = static::fenomeno_natural();

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

        $info = Des_natural::fetchArray($sql);


        echo json_encode($info);
    }

    function DrogasCantGraficaAPI(){
        

        $fecha1 = str_replace('T', ' ', $_POST['fecha_grafica']);
            $fecha2 = str_replace('T', ' ', $_POST['fecha_grafica2']);
   

      $tipos = static::fenomeno_natural();
     
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


            $info = Des_natural::fetchArray($sql);
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
                $info = Des_natural::fetchArray($sql);
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
            $info = Des_natural::fetchArray($sql);
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
            $info = Des_natural::fetchArray($sql);
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
        $result = Des_natural::fetchArray($sentencia);
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
        $result = Des_natural::fetchArray($sentencia);
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

            $tipos = static::fenomeno_natural();

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

            $tipos = static::fenomeno_natural();

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
                    $info = Des_natural::fetchArray($sql);
                    $meses1[]= $mes1;
                    $cantidades[$mes1]= (int) $info[0]['cantidad'];
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
                    $sql=" SELECT  sum (cantidad) as cantidad from amc_incautacion_droga  inner join amc_topico on amc_incautacion_droga.topico = amc_topico.id  where  year(amc_topico.fecha) = $años[$i] and month(amc_topico.fecha) = $meses[$i] and amc_topico.situacion = 1 and amc_incautacion_droga.situacion = 1";
                    $info = Des_natural::fetchArray($sql);
                    $valor = $info[0]['cantidad'];
                    
                    $meses1[]= $mes1;
                    $cantidades[$mes1]= (int) $info[0]['cantidad'];
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
