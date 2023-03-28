<?php

namespace Controllers;

use Exception;

use DateTime;
use Model\Captura;
use Model\Capturadas;

use Model\DepMun;
// use Model\Delito;
use MVC\Router;

class InfoMarasController
{

    public static function index(Router $router)
    {
        hasPermission(['AMC_ADMIN']);

        $maras_actividades = static::maras_actividades();
        $marerosCapturados = static::marerosCapturados();
        $capturas18 = static::capturas18();
        $capturasSalvatrucha = static::capturasSalvatrucha();
        $deptoIncidencia = static::departamentoMasIncidenciaMaras();
        $colores = static::coloresAPI1();
        $incidencia_mara = static::incidencia_mara();
        $topicos = static::tiposTopicos();
        $router->render('mapas/maras', [
            'maras_actividades' => $maras_actividades,
            'capturasSalvatrucha' => $capturasSalvatrucha,
            'deptoIncidencia' => $deptoIncidencia,
            'marerosCapturados' => $marerosCapturados,
            'capturas18' => $capturas18,
            'incidencia_mara' => $incidencia_mara,
            'topicos' => $topicos,
            'colores' => $colores,
        ]);
    }




    protected static function maras_actividades($fecha1 = "", $fecha2 = "", $depto = "", $mara = "", $topico1 = "")
    {
        // hasPermissionApi(['AMC_ADMIN']);


        $sql = "   SELECT count (*) as cantidad from amc_topico where amc_topico.situacion = 1  ";


        if ($fecha1 != '' && $fecha2 != '') {

            $sql .= " AND amc_topico.fecha   BETWEEN '$fecha1' AND  '$fecha2' ";
        } else {

            $sql .= " AND year(amc_topico.fecha) = year(current)  and  month(amc_topico.fecha) = month(current) ";
        }
        if ($mara != "") {

            $sql .= " AND amc_topico.actividad = $mara";
        } else {

            $sql .= " and amc_topico.actividad in (1,5)";
        }
        if ($depto != '') {

            $sql .= " AND amc_topico.departamento = $depto";
        }
        if ($topico1 != '') {

            $sql .= " AND amc_topico.tipo = $topico1";
            
        }

        $result = Capturadas::fetchArray($sql);

    //  
        if ($result[0]['cantidad']) {
            return $result;
        } else {

            $result = [[
                "cantidad" =>
                "0"
            ]];
            return $result;
        }
    }

    protected static function marerosCapturados($fecha1 = "", $fecha2 = "", $depto = "")
    {
        // hasPermissionApi(['AMC_ADMIN']);


        $sql = "   SELECT count (*) as cantidad from amc_per_capturadas inner join amc_topico on amc_per_capturadas.topico = amc_topico.id  where  amc_topico.situacion = 1 and amc_per_capturadas.vinculo in (1,2)  and amc_topico.dependencia = (SELECT org_dependencia from mper inner join morg on per_plaza = org_plaza where per_catalogo = user)  ";
        if ($fecha1 != '' && $fecha2 != '') {

            $sql .= " AND amc_topico.fecha   BETWEEN '$fecha1' AND  '$fecha2' ";
        } else {

            $sql .= " AND year(amc_topico.fecha) = year(current)  and  month(amc_topico.fecha) = month(current) ";
        }
        if ($depto != '') {

            $sql .= " AND amc_topico.depto = $depto";
        }

        $result = Capturadas::fetchArray($sql);
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


    protected static  function capturas18($fecha1 = "", $fecha2 = "", $depto = "")
    {
        // hasPermissionApi(['AMC_ADMIN']);


        $sql = "   SELECT count (*) as cantidad from amc_per_capturadas inner join amc_topico on amc_per_capturadas.topico = amc_topico.id  where  amc_topico.situacion = 1 and amc_per_capturadas.vinculo = 1  and amc_topico.dependencia = (SELECT org_dependencia from mper inner join morg on per_plaza = org_plaza where per_catalogo = user) ";

        if ($fecha1 != '' && $fecha2 != '') {

            $sql .= " AND amc_topico.fecha   BETWEEN '$fecha1' AND  '$fecha2' ";
        } else {

            $sql .= " AND year(amc_topico.fecha) = year(current)  and  month(amc_topico.fecha) = month(current) ";
        }
        if ($depto != '') {

            $sql .= " AND amc_topico.departamento = $depto";
        }
        // if($topico != ''){

        //     $sql.= " AND amc_topico.tipo = $topico";
        //  }

        $result = Capturadas::fetchArray($sql);
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

    protected static function capturasSalvatrucha($fecha1 = "", $fecha2 = "", $depto = "")
    {

        // hasPermissionApi(['AMC_ADMIN']);

        $sql = "   SELECT count (*) as cantidad from amc_per_capturadas inner join amc_topico on amc_per_capturadas.topico = amc_topico.id  where  amc_topico.situacion = 1 and amc_per_capturadas.vinculo = 2  and amc_topico.dependencia = (SELECT org_dependencia from mper inner join morg on per_plaza = org_plaza where per_catalogo = user) ";

        if ($fecha1 != '' && $fecha2 != '') {

            $sql .= " AND amc_topico.fecha   BETWEEN '$fecha1' AND  '$fecha2' ";
        } else {

            $sql .= " AND year(amc_topico.fecha) = year(current)  and  month(amc_topico.fecha) = month(current) ";
        }
        if ($depto != '') {

            $sql .= " AND amc_topico.departamento = $depto";
        }

        $result = Capturadas::fetchArray($sql);
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


    protected static  function departamentoMasIncidenciaMaras($fecha1 = "", $fecha2 = "")
    {

        // hasPermissionApi(['AMC_ADMIN']);

        $sql = "SELECT FIRST 1 amc_topico.departamento as departamento, count(*) as cantidad FROM amc_topico  where year(amc_topico.fecha) = year(current) and amc_topico.actividad in (1,5) and amc_topico.situacion = 1  and amc_topico.dependencia = (SELECT org_dependencia from mper inner join morg on per_plaza = org_plaza where per_catalogo = user) ";

        if ($fecha1 != '' && $fecha2 != '') {

            $sql .= " AND amc_topico.fecha   BETWEEN '$fecha1' AND  '$fecha2' ";
        } else {

            $sql .= " AND year(amc_topico.fecha) = year(current)  and  month(amc_topico.fecha) = month(current) ";
        }


        $sql .= "group by departamento order by cantidad desc";



        $result = Capturadas::fetchArray($sql);

        if ($result) {
            foreach ($result as $row) {

                $depto = $row['departamento'];
            }

            $sql = "SELECT dm_desc_lg as desc from depmun where dm_codigo = $depto ";
            $result = Capturadas::fetchArray($sql);
            return $result;
        } else {

            $delito = [[
                'desc' => "Sin datos"
            ]];
            return $delito;
        }
    }



    protected static function incidencia_mara($fecha1 = "", $fecha2 = "",  $depto = "", $tipo = "")
    {
        // hasPermissionApi(['AMC_ADMIN']);



        $sql = "        SELECT FIRST 1  amc_tipo_topics.desc as descripcion,  count(*) as cantidad, amc_topico.tipo as tipo from amc_topico inner join amc_tipo_topics on amc_topico.tipo = amc_tipo_topics.id where amc_topico.situacion = 1  and amc_topico.actividad in(1,5)  and amc_topico.dependencia = (SELECT org_dependencia from mper inner join morg on per_plaza = org_plaza where per_catalogo = user)  ";

        if ($fecha1 != '' && $fecha2 != '') {

            $sql .= " AND amc_topico.fecha   BETWEEN '$fecha1' AND  '$fecha2' ";
        } else {

            $sql .= " AND year(amc_topico.fecha) = year(current)  and  month(amc_topico.fecha) = month(current) ";
        }
        if ($tipo != '') {

            $sql .= " AND amc_topico.tipo = $tipo";
        }
        if ($depto != '') {

            $sql .= " AND amc_topico.depto = $depto";
        }

        if ($fecha1 != '' && $fecha2 != '') {

            $sql .= " AND amc_topico.fecha   BETWEEN '$fecha1' AND  '$fecha2' ";
        }
        $sql .= " group by descripcion, tipo  order by cantidad desc";
        $result = Capturadas::fetchArray($sql);

        if ($result[0]['cantidad'] != '') {


            return $result;
        } else {

            $result = [[
                "descripcion" =>
                "Sin datos",
                "municion" => "",
                "tipo" => "0"
            ]];
            return $result;
        }
    }







    public static function resumenAPI()
    {
        hasPermissionApi(['AMC_ADMIN']);

        // getHeadersApi();
        // echo json_encode($_POST) ;


        $fecha1 = $_POST['fecha_resumen'];
        $fecha2 = $_POST['fecha_resumen2'];

        $fecha1 = str_replace('T', ' ', $fecha1);
        $fecha2 = str_replace('T', ' ', $fecha2);



        // $capturas = static::cantidadCapturas($fecha1, $fecha2);

        $maras_actividades = static::maras_actividades($fecha1, $fecha2);
        $marerosCapturados = static::marerosCapturados($fecha1, $fecha2);
        $capturasSalvatrucha = static::capturasSalvatrucha($fecha1, $fecha2);
        $capturas18 = static::capturas18($fecha1, $fecha2);
        $incidencia_mara = static::incidencia_mara($fecha1, $fecha2);
        $depto = static::departamentoMasIncidenciaMaras($fecha1, $fecha2);
        $array_resultante = array_merge($maras_actividades, $marerosCapturados, $capturasSalvatrucha, $capturas18, $depto, $incidencia_mara);

        echo json_encode($array_resultante);
    }


    public static function listadoAPI()
    {
        getHeadersApi();
        hasPermissionApi(['AMC_ADMIN']);

        try {

            $sql = "SELECT DISTINCT  amc_topico.id as id, amc_topico.lugar as lugar, amc_topico.tipo as tipo, amc_tipo_topics.desc as topico,  amc_topico.fecha as fecha, dm_desc_lg as departamento,   amc_actividad_vinculada.desc as actividad from amc_topico inner join amc_tipo_topics on amc_topico.tipo = amc_tipo_topics.id inner join depmun on amc_topico.departamento = depmun.dm_codigo  inner join amc_actividad_vinculada on amc_topico.actividad = amc_actividad_vinculada.id and amc_topico.actividad in (1,5) and amc_topico.situacion = 1  and amc_topico.dependencia = (SELECT org_dependencia from mper inner join morg on per_plaza = org_plaza where per_catalogo = user) ";
            $info = Captura::fetchArray($sql);

            $data = [];

            $i = 1;
            foreach ($info as $key) {
                $id = $key['id'];
                $lugar = $key['lugar'];
                $fecha = $key['fecha'];
                $municipio = trim($key['departamento']);
                $topico = $key['topico'];
                $tipo = $key['tipo'];
                $actividad = $key['actividad'];


                $arrayInterno = [[
                    "contador" => $i,
                    "id" => $id,
                    "lugar" => $lugar,
                    "fecha" => $fecha,
                    "departamento" => $municipio,
                    "topico" => $topico,
                    "tipo" => $tipo,
                    "actividad" => $actividad,

                ]];
                $i++;
                $data = array_merge($data, $arrayInterno);
            }

            // $arrayreturn = ["data" => $data];
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
        hasPermissionApi(['AMC_ADMIN']);


        try {


            $id = $_POST['id'];
            $sql = "SELECT DISTINCT amc_topico.id as id, amc_topico.lugar as lugar, amc_topico.municipio, amc_topico.latitud, amc_topico.longitud, amc_topico.fecha,  amc_topico.tipo as tipo, amc_tipo_topics.desc as topico,  amc_topico.fecha as fecha, dm_desc_lg as departamento,  amc_actividad_vinculada.desc as actividad from amc_topico  inner join amc_tipo_topics on amc_topico.tipo = amc_tipo_topics.id inner join depmun on amc_topico.departamento = depmun.dm_codigo  inner join amc_actividad_vinculada on amc_topico.actividad = amc_actividad_vinculada.id where amc_topico.situacion = 1  and amc_topico.id = $id  and amc_topico.dependencia = (SELECT org_dependencia from mper inner join morg on per_plaza = org_plaza where per_catalogo = user) ";

            $info = Capturadas::fetchArray($sql);
            $data = [];


            $i = 1;
            foreach ($info as $key) {
                $id = $key['id'];
                $lugar = $key['lugar'];
                $fecha = $key['fecha'];
                $depto = trim((string)$key['departamento']);
                $municipio = $key['municipio'];
                $latitud = $key['latitud'];
                $longitud = $key['longitud'];
                $tipo = $key['tipo'];
                $topico = $key['topico'];

                $actividad = $key['actividad'];



                // if ($depto < 1000) {

                //     $depto = '0' . $depto;
                // }

                //    $sql1 = "SELECT dm_desc_md as municipio from depmun where dm_codigo = $municipio ";

                $municipio = DepMun::fetchArray("SELECT dm_desc_lg from depmun where dm_codigo = $municipio");
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
                    "tipo" => $tipo,
                    "latitud" => $latitud,
                    "longitud" => $longitud,
                    "topico" => $topico,
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



    public static function informacionCapturasModalAPI()
    {
        getHeadersApi();
        hasPermissionApi(['AMC_ADMIN']);

        // echo json_encode($sql);

        try {

            $id = $_POST['id'];

            $sql = "SELECT amc_per_capturadas.id, amc_per_capturadas.topico, amc_nacionalidad.desc as nacionalidad, amc_sexo.desc as sexo, amc_per_capturadas.nombre, amc_per_capturadas.edad, amc_delito.desc as delito  from amc_per_capturadas inner join amc_nacionalidad on amc_per_capturadas.nacionalidad = amc_nacionalidad.id inner join amc_sexo on amc_sexo.id = amc_per_capturadas.sexo inner join amc_delito on amc_per_capturadas.delito = amc_delito.id where topico = $id and amc_per_capturadas.situacion = 1  " ;
            $info = Capturadas::fetchArray($sql);
            $data = [];

            $i = 1;
            foreach ($info as $key) {
                $id = $key['id'];
                $sexo = $key['sexo'];
                $nacionalidad = ($key['nacionalidad']);
                $nombre = ($key['nombre']);
                $topico = $key['topico'];
                $delito = ($key['delito']);
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


    public static function informacionDrogaModalAPI()
    {
        getHeadersApi();
        hasPermissionApi(['AMC_ADMIN']);

        // echo json_encode($sql);

        try {

            $id = $_POST['id'];


            $sql = "SELECT amc_incautacion_droga.cantidad as cantidad,  amc_incautacion_droga.tipo_transporte as tipo_t, amc_incautacion_droga.id, amc_incautacion_droga.tipo_droga, matricula, amc_drogas.desc as droga, amc_transporte.desc as transporte   from amc_incautacion_droga inner join amc_drogas on amc_incautacion_droga.tipo_droga = amc_drogas.id inner join amc_transporte on amc_incautacion_droga.transporte = amc_transporte.id where amc_incautacion_droga.topico =$id and  amc_incautacion_droga.situacion = 1 ";

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


    public static function informacionMuerteModalAPI()
    {
        getHeadersApi();
        hasPermissionApi(['AMC_ADMIN']);

        // echo json_encode($sql);

        try {

            $id = $_POST['id'];

            $sql = " SELECT amc_per_asesinadas.id, amc_per_asesinadas.topico,  amc_sexo.desc as sexo, amc_per_asesinadas.nombre, amc_per_asesinadas.situacion, amc_per_asesinadas.edad  from amc_per_asesinadas inner join amc_sexo on amc_sexo.id = amc_per_asesinadas.sexo  where topico = $id and amc_per_asesinadas.situacion > 0 ";
            $info = Captura::fetchArray($sql);
            $data = [];

            $i = 1;
            foreach ($info as $key) {
                $id = $key['id'];
                $sexo = $key['sexo'];

                $nombre = $key['nombre'];
                $topico = $key['topico'];
                $tipo = $key['situacion'];
                $edad = $key['edad'];

                switch ($tipo) {

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
                    "sexo" => $sexo,
                    "nombre" => $nombre,
                    "topico" => $topico,
                    "muerte" => $tipo,
                    "edad" => $edad,




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



    public static function informacionDineroModalAPI()
    {
        getHeadersApi();
        hasPermissionApi(['AMC_ADMIN']);

        // echo json_encode($sql);

        try {

            $id = $_POST['id'];


            $sql = "SELECT amc_incautacion_dinero.cantidad as cant, amc_moneda.desc,  amc_incautacion_dinero.conversion  from amc_incautacion_dinero inner join amc_moneda on amc_incautacion_dinero.moneda = amc_moneda.id inner join amc_topico on amc_topico.id = amc_incautacion_dinero.topico where  amc_incautacion_dinero.situacion = 1 and amc_incautacion_dinero.topico = $id  ";

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

    public static function informacionArmasModalAPI()
    {
        getHeadersApi();
        hasPermissionApi(['AMC_ADMIN']);

        // echo json_encode($sql);

        try {

            $id = $_POST['id'];


            $sql = " SELECT amc_tipo_armas.desc as tipo_arma, amc_calibre.desc as calibre, amc_detalle_arma.cantidad as cantidad  from amc_detalle_arma inner join amc_tipo_armas on amc_tipo_armas.id = amc_detalle_arma.tipo_arma inner join amc_calibre on amc_calibre.id = amc_detalle_arma.calibre  where amc_detalle_arma.topico = $id and amc_detalle_arma.situacion = 1";
            $info = Capturadas::fetchArray($sql);
            $data = [];

            $i = 1;
            if ($info) {
                foreach ($info as $key) {
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

    public static function informacionMunicionModalAPI()
    {
        getHeadersApi();
        hasPermissionApi(['AMC_ADMIN']);

        // echo json_encode($sql);

        try {

            $id = $_POST['id'];


            $sql = " SELECT  amc_calibre.desc as calibre, amc_detalle_municion.cantidad as cantidad  from amc_detalle_municion  inner join amc_calibre on amc_calibre.id = amc_detalle_municion.calibre  where amc_detalle_municion.topico = $id and amc_detalle_municion.situacion = 1
            ";
            $info = Capturadas::fetchArray($sql);
            $data=[];
            
            $i=1;
            if($info){
            foreach($info as $key){ 
               $calibre = $key['calibre'];
               $cantidad = $key['cantidad'];
              
                $arrayInterno = [[
                   "contador" => $i,
                   "calibre" => $calibre,
                   "cantidad" => $cantidad  
                
               ]];
               $i++;
               $data = array_merge($data,$arrayInterno);
            
            
            }}
         
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
        hasPermissionApi(['AMC_ADMIN']);

        // echo json_encode($sql);

        try {
            $topico = $_POST['topico_mapa_calor'];
            $fecha1 = str_replace('T', ' ', $_POST['fecha_mapa']);
            $fecha2 = str_replace('T', ' ', $_POST['fecha2']);


          
   $sql = " SELECT distinct dm_desc_lg as descripcion, dm_codigo as codigo, count (*) as cantidad FROM amc_topico inner join depmun on departamento = dm_codigo  where  amc_topico.situacion = 1 and amc_topico.actividad in (1,5)  and amc_topico.dependencia = (SELECT org_dependencia from mper inner join morg on per_plaza = org_plaza where per_catalogo = user)  ";
            if ($topico != '') {

                $sql .= "AND amc_topico.tipo = $topico";
            }
            if ($fecha1 != '' && $fecha2 != '') {
                $sql .= " AND amc_topico.fecha   BETWEEN '$fecha1' AND  '$fecha2' ";
            }
            if ($fecha1 == '' && $fecha2 == '') {
                $sql .= " AND year(fecha) = year(current) AND month(fecha) = month(current)  ";
            }
            $sql .= " group by descripcion, codigo ";

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


    public static function coloresAPI()
    {
        getHeadersApi();
        hasPermissionApi(['AMC_ADMIN']);
        try {
            $sql = "SELECT * from amc_colores where topico = 11 and situacion = 1 order by nivel asc ";
            $info = Capturadas::fetchArray($sql);
            echo json_encode($info);
        } catch (Exception $e) {
            return [];
        }
    }


    public static function mapaCalorDeptoAPI()
    {
        getHeadersApi();
        hasPermissionApi(['AMC_ADMIN']);
        try {

            $depto = $_POST['departamento'];
            // $delito = $_POST['delitos_mapa_calor'];
            $fecha1 = str_replace('T', ' ', $_POST['fecha_mapa']);
            $fecha2 = str_replace('T', ' ', $_POST['fecha2']);


            $total_18 = static::capturas18($fecha1, $fecha2,$depto);
            $total_salvatrucha = static::capturasSalvatrucha($fecha1, $fecha2,$depto);
            // $total_armas = $clase->total_armas($mes="", $depto, $droga, $calibre="", $fecha1, $fecha2);
         
           
            $array_resultante= array_merge($total_18, $total_salvatrucha );
         
         echo json_encode($array_resultante);
        } catch (Exception $e) {
            return [];
        }
    }

    public static function mapaCalorPorDeptoGraficaAPI()
    {
        getHeadersApi();
        hasPermissionApi(['AMC_ADMIN']);
        try {


            $depto = $_POST['departamento'];
            $topico = $_POST['topico_mapa_calor'];
            $fecha1 = str_replace('T', ' ', $_POST['fecha_mapa']);
            $fecha2 = str_replace('T', ' ', $_POST['fecha2']);
        
            $tipo_topic = static::tiposTopicos();
           
            $data = [];
            $labels = [];
            $armas = [];
            $cantidades = [];
            $i = 0;
            $dato = 0;
           //  if($arma == ''){
           if($topico == ""){
              for($i = 1; $i <=2 ; $i++  ){
           
                 foreach ($tipo_topic as $key => $tipo ) {
           
                    $clase_topico = (int)$tipo['id'];
                    
                    $labels[]= $tipo['desc'];
                    if($i == 1){
                       $dataset = "MARA SALVATRUCHA";
                       $mara = 5;
                    }
                    if($i == 2){
                       $dataset = "MARA 18";
                       $mara = 1;
                    }
                    
                   
                    $operaciones = static::departamental_grafica($fecha1 , $fecha2, $depto, $mara, $clase_topico  );
                 

                    if($operaciones[0]['cantidad'] > 0 ){
                        $dato = $dato + 1;

                    }
                    $cantidades[$dataset][]= (int) $operaciones[0]['cantidad'];            
            //         echo json_encode($operaciones);
                
            //   exit();
            
           }
             
           
            
              }
            }else{
                for($i = 1; $i <=2 ; $i++  ){
           
                  
                    
                       if($i == 1){
                          $dataset = "MARA SALVATRUCHA";
                          $mara = 5;
                       }
                       if($i == 2){
                          $dataset = "MARA 18";
                          $mara = 1;
                       }
                       
                      
                       $operaciones = static::departamental_grafica($fecha1 , $fecha2, $depto, $mara, $topico  );
                       
                      
                       if($operaciones[0]['cantidad'] > 0 ){
                           $dato = $dato + 1;
   
                       }
                       $cantidades[$dataset][]= (int) $operaciones[0]['cantidad'];            
               
                 }

            }
        
           foreach ($tipo_topic as $key => $tipo ) {
           
           $arma = $tipo['id'];
           
           $armas[]= $tipo['desc'];
           }
           
           $data = [
           'labels' => $armas,
           'cantidades' => $cantidades,
           'dato' => $dato
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

    public static function DelitosCantGraficaAPI()
    {
        getHeadersApi();
        hasPermissionApi(['AMC_ADMIN']);
        try {


            $depto = $_POST['departamento'];
            $topico = $_POST['topico_mapa_calor'];
            $fecha1 = str_replace('T', ' ', $_POST['fecha_grafica']);
            $fecha2 = str_replace('T', ' ', $_POST['fecha_grafica2']);
        
            $tipo_topic = static::tiposTopicos();
           

            $data = [];
            $labels = [];
            $armas = [];
            $cantidades = [];
            $i = 0;
            //  if($arma == ''){
            
            for($i = 1; $i <=2 ; $i++  ){
            
               foreach ($tipo_topic as $key => $tipo ) {
            
                  $topico = $tipo['id'];
                  
                  $labels[]= $tipo['desc'];
                  if($i == 1){
                     $dataset = "MARA SALVATRUCHA";
                     $mara = 5;
                  }
                  if($i == 2){
                     $dataset = "BARRIO 18";
                     $mara = 1;
                  }
            
                 
                  $operaciones =static::departamental_grafica(  $fecha1 , $fecha2, $depto, $mara, $topico );
                  if($i == 1){
                     $dataset = "MARA SALVATRUCHA";
                  }
                  if($i == 2){
                     $dataset = "BARRIO 18";
                  }
                  $cantidades[$dataset][]= (int) $operaciones[0]['cantidad'];
            
            
            
                  // echo json_encode($operaciones);
            
            
            }
            
            
            
            }
            
            // exit();
            foreach ($tipo_topic as $key => $tipo ) {
            
            $arma = $tipo['id'];
            
            $armas[]= $tipo['desc'];
            }
            
            $data = [
            'labels' => $armas,
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


    public static function departamental_grafica($fecha1 , $fecha2, $depto, $mara, $topico){
        hasPermissionApi(['AMC_ADMIN']);


        return static::maras_actividades($fecha1 , $fecha2, $depto, $mara, $topico);


     }


  

    public static function ActividadesPorDiaGraficaAPI()
    {
        hasPermissionApi(['AMC_ADMIN']);

        try {


            $diasMes =  date('t');
            $data = [];
            for ($i = 0; $i <=  $diasMes; $i++) {
                // $main = new Main();
                $sql ="SELECT count(*) as  cantidad  From amc_topico  where year(amc_topico.fecha) = year(current) and month(amc_topico.fecha) = month(current) and day(amc_topico.fecha) = day($i) and amc_topico.situacion = 1 and amc_topico.actividad in (1,5)  and amc_topico.dependencia = (SELECT org_dependencia from mper inner join morg on per_plaza = org_plaza where per_catalogo = user) ";
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

    public static function Mara18PorDiaGraficaAPI()
    {
        hasPermissionApi(['AMC_ADMIN']);
        try {


            $diasMes =  date('t');
            $data = [];
            for ($i = 0; $i <=  $diasMes; $i++) {
                // $main = new Main();
                $sql ="SELECT count(*) as  cantidad  From amc_topico  where year(amc_topico.fecha) = year(current) and month(amc_topico.fecha) = month(current) and day(amc_topico.fecha) = day($i) and amc_topico.situacion = 1 and amc_topico.actividad = 1  and amc_topico.dependencia = (SELECT org_dependencia from mper inner join morg on per_plaza = org_plaza where per_catalogo = user) ";
                $info = Capturadas::fetchArray($sql);
                $data['dias'][] = $i;
                if ($info[0]['cantidad'] == null) {

                    $valor = 0;
                } else {
                    $valor = $info[0]['cantidad'];
                }
                $data['mara18'][] = $valor;
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


    public static function SalvatruchaPorDiaGraficaAPI()
    {
        hasPermissionApi(['AMC_ADMIN']);
        try {


            $diasMes =  date('t');
            $data = [];
            for ($i = 0; $i <=  $diasMes; $i++) {
                // $main = new Main();
                $sql ="SELECT count(*) as  cantidad  From amc_topico  where year(amc_topico.fecha) = year(current) and month(amc_topico.fecha) = month(current) and day(amc_topico.fecha) = day($i) and amc_topico.situacion = 1 and amc_topico.actividad = 5  and amc_topico.dependencia = (SELECT org_dependencia from mper inner join morg on per_plaza = org_plaza where per_catalogo = user) ";
                $info = Capturadas::fetchArray($sql);
                $data['dias'][] = $i;
                if ($info[0]['cantidad'] == null) {

                    $valor = 0;
                } else {
                    $valor = $info[0]['cantidad'];
                }
                $data['salvatrucha'][] = $valor;
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

    public static function GraficaTrimestralMara18API()
    {
        hasPermissionApi(['AMC_ADMIN']);
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

            $tipos = static::tiposTopicos();

            $data = [];
            $labels = [];
            $cantidades = [];
            $i = 0;

            foreach ($tipos as $tipo) {
                $tipo_id = (int)$tipo['id'];
                $labels[] = $tipo['desc'];

                for ($i = 0; $i < 3; $i++) {
                    $dateObj = DateTime::createFromFormat('!m', $meses[$i]);
                    $mes = strftime("%B", $dateObj->getTimestamp());
                    $operaciones = static::ActividadesMara18_por_mes_y_delito($meses[$i], $tipo_id, $años[$i]);
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


    public static function GraficaTrimestralSalvatruchaAPI()
    {
        hasPermissionApi(['AMC_ADMIN']);
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

            $tipos = static::tiposTopicos();

            $data = [];
            $labels = [];
            $cantidades = [];
            $i = 0;

            foreach ($tipos as $tipo) {
                $tipo_id = (int)$tipo['id'];
                $labels[] = $tipo['desc'];

                for ($i = 0; $i < 3; $i++) {
                    $dateObj = DateTime::createFromFormat('!m', $meses[$i]);
                    $mes = strftime("%B", $dateObj->getTimestamp());
                    $operaciones = static::ActividadesSalvatrucha_por_mes_y_delito($meses[$i], $tipo_id, $años[$i]);
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

    public static function GraficaTrimestralGeneralAPI()
    {
        hasPermissionApi(['AMC_ADMIN']);
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
                    $sql=" SELECT  count (*) as cantidad from amc_topico   where  year(amc_topico.fecha) = $años[$i] and month(amc_topico.fecha) =$meses[$i] and amc_topico.situacion = 1 and amc_topico.situacion = 1 and amc_topico.actividad in(1,5)  and amc_topico.dependencia = (SELECT org_dependencia from mper inner join morg on per_plaza = org_plaza where per_catalogo = user) ";
                    $info = Capturadas::fetchArray($sql);
                    // $valor = $info[0]['cantidad'];
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

    protected static function tiposTopicos(){
        // hasPermissionApi(['AMC_ADMIN']);


        $sql = "SELECT * from amc_tipo_topics where situacion = 1";
        $result = Capturadas::fetchArray($sql);
        return $result;
    }

    public static function ActividadesMara18_por_mes_y_delito($mes, $topico, $año)
    {

        $sentencia = "SELECT count(*) as  cantidad  from amc_topico  where year(amc_topico.fecha) = $año and month(amc_topico.fecha) = $mes  and amc_topico.situacion = 1 and amc_topico.situacion = 1 and amc_topico.tipo = $topico and amc_topico.actividad = 1  and amc_topico.dependencia = (SELECT org_dependencia from mper inner join morg on per_plaza = org_plaza where per_catalogo = user) " ;
        
        $result = Capturadas::fetchArray($sentencia);
        return array_shift($result);
    }



    public static function ActividadesSalvatrucha_por_mes_y_delito($mes, $topico, $año)
    {

        hasPermissionApi(['AMC_ADMIN']);

        $sentencia = "SELECT count(*) as  cantidad  from amc_topico  where year(amc_topico.fecha) = $año and month(amc_topico.fecha) = $mes  and amc_topico.situacion = 1 and amc_topico.situacion = 1 and amc_topico.tipo = $topico and amc_topico.actividad = 5  and amc_topico.dependencia = (SELECT org_dependencia from mper inner join morg on per_plaza = org_plaza where per_catalogo = user) ";

        
        $result = Capturadas::fetchArray($sentencia);
        return array_shift($result);
    }


    public static function DelitosDepartamentoGraficaAPI()
    {
        hasPermissionApi(['AMC_ADMIN']);
        try {


            $fecha1 = str_replace('T', ' ', $_POST['fecha_grafica']);
            $fecha2 = str_replace('T', ' ', $_POST['fecha_grafica2']);



            $sql ="SELECT depmun.dm_desc_lg as descripcion, count(*) as cantidad FROM amc_topico  inner join depmun on amc_topico.departamento = depmun.dm_codigo where amc_topico.situacion = 1 and amc_topico.actividad in (1,5)  and amc_topico.dependencia = (SELECT org_dependencia from mper inner join morg on per_plaza = org_plaza where per_catalogo = user) ";


            
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


    protected static function coloresAPI1()
    {
        // hasPermissionApi(['AMC_ADMIN']);

        try {
            $sql = "SELECT * from amc_colores where topico = 11  ";
            $info = Capturadas::fetchArray($sql);
            return $info;
        } catch (Exception $e) {
            return [];
        }
    }


   
}
