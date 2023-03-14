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
        hasPermission(['AMC_ADMIN']);

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
        $fenomeno_natural = static::fenomeno_natural();

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

        hasPermission(['AMC_ADMIN']);

        $sentencia = "SELECT * from amc_fenomeno_natural where situacion = 1";
        $result = Des_natural::fetchArray($sentencia);
        return $result;
    }

    static public function coloresAPI()
    {
        getHeadersApi();
        hasPermission(['AMC_ADMIN']);

        try {
            $sql = "SELECT * from amc_colores where topico = 7 and situacion = 1 order by nivel asc ";
            $info = Des_natural::fetchArray($sql);
            echo json_encode($info);
        } catch (Exception $e) {
            return [];
        }
    }

    static public function coloresAPI1()
    {
        hasPermission(['AMC_ADMIN']);


        try {
            $sql = "SELECT * from amc_colores where topico = 7  ";
            $info = Des_natural::fetchArray($sql);
            return $info;
        } catch (Exception $e) {
            return [];
        }
    }
    protected static function cantidadDesastres($fecha1 = "", $fecha2 = "")
    {
        hasPermission(['AMC_ADMIN']);


        $sql = " SELECT  count (*) as cantidad from amc_desastre_natural 
        inner join amc_topico on amc_desastre_natural.topico = amc_topico.id 
        where  amc_topico.situacion = 1 and amc_desastre_natural.situacion = 1 and amc_topico.dependencia = (SELECT org_dependencia from mper inner join morg on per_plaza = org_plaza where per_catalogo = user) ";

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


    static function totalPersonasEvacuadas($fecha1 = "", $fecha2 = "",  $fenomeno = "", $depto="")
    {

        hasPermission(['AMC_ADMIN']);

        $sql = "SELECT  sum(amc_desastre_natural.per_evacuada) as cantidad from amc_desastre_natural inner join amc_topico on amc_desastre_natural.topico = amc_topico.id  where  amc_desastre_natural.situacion = 1 and amc_topico.dependencia = (SELECT org_dependencia from mper inner join morg on per_plaza = org_plaza where per_catalogo = user) ";



        if ($fecha1 == '' && $fecha2 == '') {

            $sql .= " AND year(amc_topico.fecha) = year(current) and month(amc_topico.fecha) = month(current) ";
        }

        if ($fenomeno != ''   ) {

            $sql .= " AND amc_desastre_natural.nombre_desastre = $fenomeno";
        }

        if ($depto != ''   ) {

            $sql .= " AND amc_topico.departamento = $depto";
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


    static function totalalbergues($fecha1 = "", $fecha2 = "",  $fenomeno = "", $depto="")
    {
        hasPermission(['AMC_ADMIN']);


        $sql = "SELECT  sum(amc_desastre_natural.albergues) as cantidad from amc_desastre_natural inner join amc_topico on amc_desastre_natural.topico = amc_topico.id  where  amc_desastre_natural.situacion = 1 and amc_topico.dependencia = (SELECT org_dependencia from mper inner join morg on per_plaza = org_plaza where per_catalogo = user) ";



        if ($fecha1 == '' && $fecha2 == '') {

            $sql .= " AND year(amc_topico.fecha) = year(current) and month(amc_topico.fecha) = month(current) ";
        }

        if ($fenomeno != ''   ) {

            $sql .= " AND amc_desastre_natural.nombre_desastre = $fenomeno";
        }

        if ($depto != ''   ) {

            $sql .= " AND amc_topico.departamento = $depto";
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


    static function totalPersonasFallecida($fecha1 = "", $fecha2 = "",  $fenomeno = "", $depto="")
    {
        hasPermission(['AMC_ADMIN']);


        $sql = "SELECT  sum(amc_desastre_natural.per_fallecida) as cantidad from amc_desastre_natural inner join amc_topico on amc_desastre_natural.topico = amc_topico.id  where  amc_desastre_natural.situacion = 1 and amc_topico.dependencia = (SELECT org_dependencia from mper inner join morg on per_plaza = org_plaza where per_catalogo = user) ";

        if ($fecha1 == '' && $fecha2 == '') {

            $sql .= " AND year(amc_topico.fecha) = year(current) and month(amc_topico.fecha) = month(current) ";
        }

        if ($fenomeno != '' ) {

            $sql .= " AND amc_desastre_natural.nombre_desastre = $fenomeno";
        }

        if ($depto != ''   ) {

            $sql .= " AND amc_topico.departamento = $depto";
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


    static function IncidenciaDesastre($fecha1 = "", $fecha2 = "", $depto="")
    {

        hasPermission(['AMC_ADMIN']);

        $sql = "  SELECT FIRST 1  amc_tipo_desastre_natural.desc, count(amc_tipo_desastre_natural.desc) as cantidad from amc_desastre_natural inner join amc_tipo_desastre_natural on amc_desastre_natural.tipo = amc_tipo_desastre_natural.id inner join amc_topico on amc_desastre_natural.topico = amc_topico.id  where  amc_desastre_natural.situacion = 1 and amc_topico.situacion = 1 and amc_topico.dependencia = (SELECT org_dependencia from mper inner join morg on per_plaza = org_plaza where per_catalogo = user) ";

        if ($fecha1 == '' && $fecha2 == '') {

            $sql .= " AND  year(amc_topico.fecha) = year(current) and month(amc_topico.fecha) = month(current) ";
        }

        if ($depto != ''   ) {

            $sql .= " AND amc_topico.departamento = $depto";
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

    static function totalPersonaAfectada($fecha1 = "", $fecha2 = "",   $fenomeno = "" , $depto ="")
    {
        hasPermission(['AMC_ADMIN']);


        $sql = "SELECT  sum(amc_desastre_natural.per_afectada) as cantidad from amc_desastre_natural inner join amc_topico on amc_desastre_natural.topico = amc_topico.id  where  amc_desastre_natural.situacion = 1 and amc_topico.dependencia = (SELECT org_dependencia from mper inner join morg on per_plaza = org_plaza where per_catalogo = user) ";

        if ($fecha1 == '' && $fecha2 == '' && $fenomeno =="") {

            $sql .= " AND year(amc_topico.fecha) = year(current) and month(amc_topico.fecha) = month(current) ";
        }

        if ($fenomeno != '' ) {

            $sql .= " AND amc_desastre_natural.nombre_desastre = $fenomeno";
        }

        if ($depto != ''   ) {

            $sql .= " AND amc_topico.departamento = $depto";
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

  
    static function EstructuraColapsada($fecha1 = "", $fecha2 = "",  $fenomeno = "", $depto="")
    {
        hasPermission(['AMC_ADMIN']);


        $sql = "SELECT  sum(amc_desastre_natural.est_colapsadas) as cantidad from amc_desastre_natural inner join amc_topico on amc_desastre_natural.topico = amc_topico.id  where amc_desastre_natural.situacion = 1 and amc_topico.dependencia = (SELECT org_dependencia from mper inner join morg on per_plaza = org_plaza where per_catalogo = user) ";

        if ($fecha1 == '' && $fecha2 == '' && $fenomeno =="") {

            $sql .= " AND year(amc_topico.fecha) = year(current) and month(amc_topico.fecha) = month(current) ";
        }

        if ($fenomeno != '' ) {

            $sql .= " AND amc_desastre_natural.nombre_desastre = $fenomeno";
        }
       
        if ($depto != ''   ) {

            $sql .= " AND amc_topico.departamento = $depto";
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

    static function Inundaciones($fecha1 = "", $fecha2 = "",  $fenomeno = "", $depto ="")
    {
        hasPermission(['AMC_ADMIN']);


        $sql = "SELECT  sum(amc_desastre_natural.inundaciones) as cantidad from amc_desastre_natural inner join amc_topico on amc_desastre_natural.topico = amc_topico.id  where  amc_desastre_natural.situacion = 1 and amc_topico.dependencia = (SELECT org_dependencia from mper inner join morg on per_plaza = org_plaza where per_catalogo = user) ";

        if ($fecha1 == '' && $fecha2 == ''&& $fenomeno =="") {

            $sql .= " AND year(amc_topico.fecha) = year(current) and month(amc_topico.fecha) = month(current) ";
        }

        if ($fenomeno != '' ) {

            $sql .= " AND amc_desastre_natural.nombre_desastre = $fenomeno";
        }

        if ($depto != ''   ) {

            $sql .= " AND amc_topico.departamento = $depto";
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


    static function Derrumbes($fecha1 = "", $fecha2 = "",  $fenomeno = "", $depto ="")
    {
        hasPermission(['AMC_ADMIN']);


        $sql = "SELECT  sum(amc_desastre_natural.derrumbes) as cantidad from amc_desastre_natural inner join amc_topico on amc_desastre_natural.topico = amc_topico.id  where  amc_desastre_natural.situacion = 1 and amc_topico.dependencia = (SELECT org_dependencia from mper inner join morg on per_plaza = org_plaza where per_catalogo = user) ";

        if ($fecha1 == '' && $fecha2 == ''&& $fenomeno =="") {

            $sql .= " AND year(amc_topico.fecha) = year(current) and month(amc_topico.fecha) = month(current) ";
        }

        if ($fenomeno != '' ) {

            $sql .= " AND amc_desastre_natural.nombre_desastre = $fenomeno";
        }
       
        if ($depto != ''   ) {

            $sql .= " AND amc_topico.departamento = $depto";
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


    static function CarreterasyPuentes($fecha1 = "", $fecha2 = "",  $fenomeno = "", $depto ="")
    {

        hasPermission(['AMC_ADMIN']);

        $sql = "SELECT  sum(amc_desastre_natural.carre_colap) as cantidad from amc_desastre_natural inner join amc_topico on amc_desastre_natural.topico = amc_topico.id  where  amc_desastre_natural.situacion = 1 and amc_topico.dependencia = (SELECT org_dependencia from mper inner join morg on per_plaza = org_plaza where per_catalogo = user) ";

        if ($fecha1 == '' && $fecha2 == '' && $fenomeno =="") {

            $sql .= " AND year(amc_topico.fecha) = year(current) and month(amc_topico.fecha) = month(current) ";
        }

        if ($fenomeno != '' ) {

            $sql .= " AND amc_desastre_natural.nombre_desastre = $fenomeno";
        }

        if ($depto != ''   ) {

            $sql .= " AND amc_topico.departamento = $depto";
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


    static function hectareasQuemadas($fecha1 = "", $fecha2 = "",  $fenomeno = "", $depto ="")
    {

        hasPermission(['AMC_ADMIN']);

        $sql = "SELECT  sum(amc_desastre_natural.hectareas_quemadas) as cantidad from amc_desastre_natural inner join amc_topico on amc_desastre_natural.topico = amc_topico.id  where  amc_desastre_natural.situacion = 1 and amc_topico.dependencia = (SELECT org_dependencia from mper inner join morg on per_plaza = org_plaza where per_catalogo = user) ";

        if ($fecha1 == '' && $fecha2 == '' && $fenomeno =="") {

            $sql .= " AND year(amc_topico.fecha) = year(current) and month(amc_topico.fecha) = month(current) ";
        }

        if ($fenomeno != '' ) {

            $sql .= " AND amc_desastre_natural.nombre_desastre = $fenomeno";
        }
       
        if ($depto != ''   ) {

            $sql .= " AND amc_topico.departamento = $depto";
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


    static function DesbordamientosRios($fecha1 = "", $fecha2 = "",  $fenomeno = "", $depto ="")
    {
        hasPermission(['AMC_ADMIN']);


        $sql = "SELECT  sum(amc_desastre_natural.rios) as cantidad from amc_desastre_natural inner join amc_topico on amc_desastre_natural.topico = amc_topico.id  where  amc_desastre_natural.situacion = 1 and amc_topico.dependencia = (SELECT org_dependencia from mper inner join morg on per_plaza = org_plaza where per_catalogo = user) ";

        if ($fecha1 == '' && $fecha2 == '' && $fenomeno =="") {

            $sql .= " AND year(amc_topico.fecha) = year(current) and month(amc_topico.fecha) = month(current) ";
        }

        if ($fenomeno != '' ) {

            $sql .= " AND amc_desastre_natural.nombre_desastre = $fenomeno";
        }
       
        if ($depto != ''   ) {

            $sql .= " AND amc_topico.departamento = $depto";
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

    static function departamentoAfectado($fecha1 = "", $fecha2 = "",  $fenomeno = "", $depto ="")
    {

        hasPermission(['AMC_ADMIN']);

        $sql = " SELECT FIRST 1 amc_fenomeno_natural.desc as nombre, dm_desc_lg as departamento, (per_fallecida + per_evacuada + per_afectada + albergues + est_colapsadas + inundaciones + derrumbes + carre_colap + hectareas_quemadas + rios)/6 as promedio, per_fallecida + per_evacuada + per_afectada + albergues + est_colapsadas + inundaciones + derrumbes + carre_colap + hectareas_quemadas + rios as suma from amc_desastre_natural inner join amc_fenomeno_natural on nombre_desastre = amc_fenomeno_natural.id inner join amc_topico on amc_desastre_natural.topico = amc_topico.id inner join depmun on amc_topico.departamento = dm_codigo  where amc_topico.situacion = 1 and amc_topico.dependencia = (SELECT org_dependencia from mper inner join morg on per_plaza = org_plaza where per_catalogo = user) ";

        if ($fecha1 == '' && $fecha2 == '' && $fenomeno =="") {

            $sql .= " AND year(amc_topico.fecha) = year(current) and month(amc_topico.fecha) = month(current) ";
        }

        if ($fenomeno != '' ) {

            $sql .= " AND amc_desastre_natural.nombre_desastre = $fenomeno";
        }

        if ($depto != ''   ) {

            $sql .= " AND amc_topico.departamento = $depto";
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



  

    public static function resumenAPI()
    {
        getHeadersApi();
        hasPermission(['AMC_ADMIN']);

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

    public static function listadoAPI()
    {
        getHeadersApi();
        hasPermission(['AMC_ADMIN']);


        try {

            $sql = "SELECT amc_fenomeno_natural.desc as nombre, dm_desc_lg as departamento, per_fallecida  as muertes, (per_fallecida + per_evacuada + per_afectada + albergues + est_colapsadas + inundaciones + derrumbes + carre_colap + hectareas_quemadas + rios)/6 as promedio, per_fallecida + per_evacuada + per_afectada + albergues + est_colapsadas + inundaciones + derrumbes + carre_colap + hectareas_quemadas + rios as suma, amc_fenomeno_natural.id as idfenomeno, amc_fenomeno_natural.desc as fenomeno, amc_topico.id as id,    amc_topico.lugar as lugar,  amc_tipo_desastre_natural.desc as tipo,  amc_topico.fecha as fecha, amc_topico.tipo as tipoTopico, depmun.dm_desc_lg as departamento from amc_desastre_natural 
            inner join amc_fenomeno_natural on nombre_desastre = amc_fenomeno_natural.id
            inner join amc_topico on amc_desastre_natural.topico = amc_topico.id
            inner join amc_tipo_desastre_natural on amc_tipo_desastre_natural.id = amc_desastre_natural.tipo
            inner join depmun on amc_topico.departamento = dm_codigo 
            where amc_topico.situacion = 1 and amc_topico.dependencia = (SELECT org_dependencia from mper inner join morg on per_plaza = org_plaza where per_catalogo = user) ";
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

    public static function modalAPI()
    {
        getHeadersApi();
        hasPermission(['AMC_ADMIN']);

        // echo json_encode($sql);

        try {

            $id = $_POST['id'];


            $sql = "SELECT amc_topico.id, fecha, lugar, departamento, municipio as muni, tipo,latitud,longitud,actividad, amc_topico.situacion, depmun.dm_desc_lg as departamento1, amc_actividad_vinculada.desc as act, amc_tipo_topics.desc as topico from amc_topico inner join depmun on amc_topico.departamento = depmun.dm_codigo inner join amc_actividad_vinculada on amc_topico.actividad = amc_actividad_vinculada.id inner join amc_tipo_topics on amc_topico.tipo = amc_tipo_topics.id where amc_topico.situacion = 1 and amc_topico.id =  $id and amc_topico.dependencia = (SELECT org_dependencia from mper inner join morg on per_plaza = org_plaza where per_catalogo = user) ";
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

    public static function informacionModalAPI()
    {
        getHeadersApi();     
           hasPermission(['AMC_ADMIN']);

        // echo json_encode($sql);

        try {

            $id = $_POST['id'];

            $sql = "SELECT * from amc_desastre_natural   inner join amc_fenomeno_natural on nombre_desastre = amc_fenomeno_natural.id inner join amc_topico on amc_desastre_natural.topico = amc_topico.id where amc_desastre_natural.topico =$id and  amc_topico.situacion = 1 and amc_topico.dependencia = (SELECT org_dependencia from mper inner join morg on per_plaza = org_plaza where per_catalogo = user) ";
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
        hasPermission(['AMC_ADMIN']);
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
        hasPermission(['AMC_ADMIN']);
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

   
    public static function mapaCalorAPI()
    {
        getHeadersApi();
        hasPermission(['AMC_ADMIN']);

        // echo json_encode($sql);

        try {
            $fenomeno = $_POST['fenomenos_mapa_calor'];
            $fecha1 = str_replace('T', ' ', $_POST['fecha_mapa']);
            $fecha2 = str_replace('T', ' ', $_POST['fecha2']);


            $sql = "  SELECT amc_fenomeno_natural.desc as nombre, dm_desc_lg as departamento,dm_codigo as codigo, amc_desastre_natural.id,
            (per_fallecida + per_evacuada + per_afectada + albergues + est_colapsadas + inundaciones + derrumbes + carre_colap + hectareas_quemadas + rios)/10 as promedio, 
            per_fallecida + per_evacuada + per_afectada + albergues + est_colapsadas + inundaciones + derrumbes + carre_colap + hectareas_quemadas + rios as suma
            from amc_desastre_natural 
            inner join amc_fenomeno_natural on nombre_desastre = amc_fenomeno_natural.id
            inner join amc_tipo_desastre_natural on amc_tipo_desastre_natural.id = amc_desastre_natural.tipo
            inner join amc_topico on amc_desastre_natural.topico = amc_topico.id
            inner join depmun on amc_topico.departamento = dm_codigo 
            where amc_topico.situacion = 1 and amc_topico.dependencia = (SELECT org_dependencia from mper inner join morg on per_plaza = org_plaza where per_catalogo = user)  ";

            if ($fenomeno != '') {

                $sql .= "AND amc_desastre_natural.nombre_desastre = $fenomeno";
            }

            if ($fecha1 != '' && $fecha2 != '') {
                $sql .= " AND amc_topico.fecha   BETWEEN '$fecha1' AND  '$fecha2' ";
            }
            if ($fecha1 == '' && $fecha2 == '') {
                $sql .= " AND year(fecha) = year(current) AND month(fecha) = month(current)";
            }
            // $sql .= " group by descripcion, codigo";

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

    public static function mapaCalorDeptoAPI()
    {
        getHeadersApi();
        hasPermission(['AMC_ADMIN']);

        try {

            $depto = $_POST['departamento'];
            $fenomeno = $_POST['fenomenos_mapa_calor'];
            $fecha1 = str_replace('T', ' ', $_POST['fecha_mapa']);
            $fecha2 = str_replace('T', ' ', $_POST['fecha2']);


            $totalPersonasEvacuadas = static::totalPersonasEvacuadas($fecha1, $fecha2,  $fenomeno, $depto );
            $IncidenciaDesastre = static::IncidenciaDesastre($fecha1, $fecha2,   $depto );
            $totalPersonaAfectada = static::totalPersonaAfectada($fecha1, $fecha2,  $fenomeno, $depto );
            $totalPersonasFallecida = static::totalPersonasFallecida($fecha1, $fecha2,  $fenomeno, $depto );
            $EstructuraColapsada = static::EstructuraColapsada($fecha1, $fecha2,  $fenomeno, $depto );
            $Inundaciones = static::Inundaciones($fecha1, $fecha2,  $fenomeno, $depto );
            $Derrumbes = static::Derrumbes($fecha1, $fecha2,  $fenomeno, $depto );
            $CarreterasyPuentes = static::CarreterasyPuentes($fecha1, $fecha2,  $fenomeno, $depto );
            $hectareasQuemadas = static::hectareasQuemadas($fecha1, $fecha2,  $fenomeno, $depto );
            $DesbordamientosRios = static::DesbordamientosRios($fecha1, $fecha2,  $fenomeno, $depto );
            $totalalbergues = static::totalalbergues($fecha1, $fecha2,  $fenomeno, $depto );
          
            $array_resultante = array_merge( $totalPersonasEvacuadas, $totalPersonaAfectada, $totalPersonasFallecida, $totalalbergues, $EstructuraColapsada,  $Inundaciones, $Derrumbes, $CarreterasyPuentes, $hectareasQuemadas, $DesbordamientosRios,  $IncidenciaDesastre);

            echo json_encode($array_resultante);
        } catch (Exception $e) {
            return [];
        }
    }

    public static function departamental_grafica( $fecha1, $fecha2, $depto, $fenomeno)
    {

      
            
        
            return static::totalPersonaAfectada($fecha1, $fecha2, $depto, $fenomeno);
        
    }


    public static function mapaCalorPorDeptoGraficaAPI()
    {
        hasPermission(['AMC_ADMIN']);

        try {


            $depto = $_POST['departamento'];
            $fenomeno = $_POST['fenomenos_mapa_calor'];
            $fecha1 = str_replace('T', ' ', $_POST['fecha_mapa']);
            $fecha2 = str_replace('T', ' ', $_POST['fecha2']);
            // echo json_encode($_POST);
            // exit;
            $sql = " SELECT amc_fenomeno_natural.desc as nombre,  
            (per_fallecida + per_evacuada + per_afectada + albergues + est_colapsadas + inundaciones + derrumbes + carre_colap + hectareas_quemadas + rios)/10 as promedio
            
             from amc_desastre_natural 
                        inner join amc_fenomeno_natural on nombre_desastre = amc_fenomeno_natural.id
                        inner join amc_tipo_desastre_natural on amc_tipo_desastre_natural.id = amc_desastre_natural.tipo
                        inner join amc_topico on amc_desastre_natural.topico = amc_topico.id
                        inner join depmun on amc_topico.departamento = dm_codigo 
                        where amc_topico.situacion = 1   AND amc_topico.departamento =  $depto and amc_topico.dependencia = (SELECT org_dependencia from mper inner join morg on per_plaza = org_plaza where per_catalogo = user) ";
                        
            if ($fenomeno != '') {

                $sql .= "AND amc_desastre_natural.nombre_desastre = $fenomeno";
            }

            if ($fecha1 != '' && $fecha2 != '') {
                $sql .= " AND amc_topico.fecha   BETWEEN '$fecha1' AND  '$fecha2' ";
            }
            if ($fecha1 == '' && $fecha2 == '') {
                $sql .= " AND year(fecha) = year(current) AND month(fecha) = month(current)";
            }


           

            $info = Des_natural::fetchArray($sql);

                
            foreach($info as $dato){
                $cantidades[] = $dato['promedio'];
                $labels[] = $dato['nombre'];
                if($dato['promedio'] != null){
                    $info1 = 1;
                }else{
                    $info1 = 0;
                }
            
            }
            
            $data = [
                'descripcion' => $labels,
                'cantidades' => $cantidades,
                'info1' => $info1
                
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
        hasPermission(['AMC_ADMIN']);

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



    
    public static function DesastresCantGraficaAPI(){

        getHeadersApi();
        hasPermission(['AMC_ADMIN']);

    

        $fenomeno_natural = $_POST['select_grafica'];
        $fecha1 = str_replace('T', ' ', $_POST['fecha_grafica']);
        $fecha2 = str_replace('T', ' ', $_POST['fecha_grafica2']);

        if($fenomeno_natural != ""){

            if($fecha1 != "" && $fecha2 != "" ){

                $grafica = Des_natural::fetchArray("SELECT sum(per_fallecida) as per_fallecida, sum(per_evacuada) as per_evacuada,sum(per_afectada) as per_afectada,sum(albergues) as albergues,sum(est_colapsadas) as est_colapsadas,
                sum(inundaciones) as inundaciones,sum(derrumbes) as derrumbes,sum(carre_colap) as carre_colap,sum(hectareas_quemadas) as hectareas_quemadas,sum(rios) as rios
                from amc_desastre_natural  inner join amc_topico on amc_desastre_natural.topico = amc_topico.id
                where nombre_desastre = $fenomeno_natural and amc_topico.fecha BETWEEN '$fecha1' AND '$fecha2' and amc_topico.dependencia = (SELECT org_dependencia from mper inner join morg on per_plaza = org_plaza where per_catalogo = user)  ");
                echo json_encode($grafica);
               
            }else{
                $grafica = Des_natural::fetchArray("select sum(per_fallecida) as per_fallecida, sum(per_evacuada) as per_evacuada,sum(per_afectada) as per_afectada,sum(albergues) as albergues,sum(est_colapsadas) as est_colapsadas,sum(inundaciones) as inundaciones,sum(derrumbes) as derrumbes,sum(carre_colap) as carre_colap,sum(hectareas_quemadas) as hectareas_quemadas,sum(rios) as rios from amc_desastre_natural  inner join amc_topico on amc_desastre_natural.topico = amc_topico.id where nombre_desastre = $fenomeno_natural and amc_topico.dependencia = (SELECT org_dependencia from mper inner join morg on per_plaza = org_plaza where per_catalogo = user) ");

                echo json_encode($grafica);

            }
      
        }elseif($fecha1 != "" && $fecha2 != ""){

            $grafica = Des_natural::fetchArray("SELECT sum(per_fallecida) as per_fallecida, sum(per_evacuada) as per_evacuada,sum(per_afectada) as per_afectada,sum(albergues) as albergues,sum(est_colapsadas) as est_colapsadas,
            sum(inundaciones) as inundaciones,sum(derrumbes) as derrumbes,sum(carre_colap) as carre_colap,sum(hectareas_quemadas) as hectareas_quemadas,sum(rios) as rios
            from amc_desastre_natural  inner join amc_topico on amc_desastre_natural.topico = amc_topico.id
            where amc_topico.fecha BETWEEN '$fecha1' AND '$fecha2'  ");
            echo json_encode($grafica);

        }



     
     

    }


    

    public static function DrogasDepartamentoGraficaAPI(){
         hasPermission(['AMC_ADMIN']);


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


    public static function IncautacionesPorDiaGraficaAPI()
    {
        hasPermission(['AMC_ADMIN']);

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



    public static function KilosPorDiaGraficaAPI(){
           hasPermission(['AMC_ADMIN']);

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



    public static function MatasPorDiaGraficaAPI(){
           hasPermission(['AMC_ADMIN']);
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

    
    public static function incautaciones_por_mes_y_droga($mes, $droga, $años)
    {
        hasPermission(['AMC_ADMIN']);

        $sentencia = "SELECT sum(cantidad) as  cantidad  from amc_incautacion_droga inner join amc_topico on amc_incautacion_droga.topico = amc_topico.id where year(amc_topico.fecha) = $años and month(amc_topico.fecha) = $mes  and amc_topico.situacion = 1 and amc_incautacion_droga.situacion = 1 and amc_incautacion_droga.tipo_droga = $droga";
        $result = Des_natural::fetchArray($sentencia);
        if ($result[0]['cantidad'] == null) {

            $valor[0]['cantidad'] = 0;
        } else {
            $valor = $result[0]['cantidad'];
        }
       
       
       
        return $valor;
    }
   
    public static function incautacionesmatas_por_mes_y_droga($mes, $droga, $años)
    {
        hasPermission(['AMC_ADMIN']);

       
        $sentencia = "SELECT sum(cantidad) as  cantidad  from amc_incautacion_droga inner join amc_topico on amc_incautacion_droga.topico = amc_topico.id where year(amc_topico.fecha) = $años and  month(amc_topico.fecha) = $mes  and amc_topico.situacion = 1 and amc_incautacion_droga.situacion = 1 and amc_incautacion_droga.tip_droga_plantacion = $droga";
        $result = Des_natural::fetchArray($sentencia);
        if ($result[0]['cantidad'] == null) {

            $valor[0]['cantidad'] = 0;
        } else {
            $valor = $result[0]['cantidad'];
        }
       
       
       
        return $valor;
    }
   
   

    public static function GraficatrimestralKilosAPI(){
            hasPermission(['AMC_ADMIN']);

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
   

    public static function GraficatrimestralMatasAPI(){
            hasPermission(['AMC_ADMIN']);

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
   


    public static function GraficatrimestralPistasAPI(){
            hasPermission(['AMC_ADMIN']);

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



    public static function GraficaTrimestralIncautacionesGeneralAPI(){
        hasPermission(['AMC_ADMIN']);
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
