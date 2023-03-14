<?php

namespace Controllers;

use Exception;
use Model\Nacionalidad;
use MVC\Router;
class NacionalidadController{

    public static function index(Router $router)
    {
        $busqueda=  Nacionalidad::fetchArray('SELECT * FROM paises');
        $router->render('nacionalidad/index',[

            'busqueda' => $busqueda,
        ]);
    }
   

    public static function guardarAPI(){
        getHeadersApi();

        try {
            $tipo = new Nacionalidad($_POST);
            $dato = $tipo->desc;
            $dato_pais = $tipo->pais;
            $existe_pais = Nacionalidad::SQL("SELECT * FROM amc_nacionalidad where pais = '$dato_pais' and situacion = 1 ");
            $existe = Nacionalidad::SQL("SELECT * FROM amc_nacionalidad where desc = '$dato' and situacion = 1 ");
            if (count($existe)>0 || count($existe_pais)>0){
               echo json_encode([
                   "mensaje" => "El registro ya existe.",
                   "codigo" => 2,
               ]);
               exit;
            }
             
            $resultado = $tipo->guardar();
            // echo json_encode($resultado['resultado']);

            if($resultado['resultado'] == 1){
                echo json_encode([
                    "mensaje" => "El registro se guardó correctamente.",
                    "codigo" => 1,
                ]);
                
            }else{
                echo json_encode([
                    "mensaje" => "Ocurrió un error.",
                    "codigo" => 0,
                ]);
    
            }
        } catch (Exception $e) {
            echo json_encode([
                "detalle" => $e->getMessage(),       
                "mensaje" => "Ocurrió un error en la base de datos.",

                "codigo" => 4,
            ]);
        }
        
    }


    // public static function buscarApi(){
    //     try {
    //         getHeadersApi();
    //         $nacionalidad = Nacionalidad::fetchArray('SELECT amc_nacionalidad.id, amc_nacionalidad.desc, paises.pai_desc_lg as pais, paises.pai_codigo as idpais from amc_nacionalidad inner join paises on amc_nacionalidad.pais = paises.pai_codigo');
    //         echo json_encode($nacionalidad);       
    //     } catch (Exception $e) {
    //         echo json_encode(["error"=>$e->getMessage()]);
    //     }
       
    // }
    public static function buscarApi(){
        getHeadersApi();
        $nacionalidad = Nacionalidad::where('situacion', '0','>');
        echo json_encode($nacionalidad);
    }
    public static function modificarAPI(){
        getHeadersApi();
        try {
            $Nacionalidad = new Nacionalidad($_POST);
            $dato = $Nacionalidad->desc;
            $existe = Nacionalidad::SQL("SELECT * FROM amc_nacionalidad where desc = '$dato' and situacion = 1 ");
            if (count($existe)>0){
               echo json_encode([
                   "mensaje" => "El registro ya existe.",
                   "codigo" => 2,
               ]);
               exit;
            }
            $resultado = $Nacionalidad->guardar();
         
    
            if($resultado['resultado'] == 1){
                echo json_encode([
                    "mensaje" => "El registro se guardó correctamente.",
                    "codigo" => 1,
                ]);
                
            }else{
                echo json_encode([
                    "mensaje" => "Ocurrió un error.",
                    "codigo" => 0,
                ]);
    
            }
        } catch (Exception $e) {
            echo json_encode([
                "detalle" => $e->getMessage(),       
                "mensaje" => "Ocurrió un error en la base de datos.",

                "codigo" => 4,
            ]);
        }
    }

    public static function eliminarAPI(){
        getHeadersApi();
        $_POST['situacion'] = 0;
        $Nacionalidad = new Nacionalidad($_POST);
        $resultado = $Nacionalidad->guardar();
        if($resultado['resultado'] == 1){
            echo json_encode([
                "resultado" => 1
            ]);   
        }else{
            echo json_encode([
                "resultado" => 0
            ]);
        }
    }
    public static function cambioSituacionAPI(){
        try{
        getHeadersApi();
    if ($_POST['situacion'] == 1){
        $_POST['situacion'] = 2;
    }else{
        $_POST['situacion'] = 1;
        }
        $Nacionalidad = new Nacionalidad($_POST);
        $resultado = $Nacionalidad->guardar();

        if($resultado['resultado'] == 1){
            echo json_encode([
                "mensaje" => "El registro se cambio correctamente.",
                "codigo" => 1,
            ]);   
        }else{
            echo json_encode([
                "mensaje" => "Ocurrió un error.",
                "codigo" => 0,
            ]);
        }
    }catch(Exception $e){
        echo json_encode([
            "detalle" => $e ->getMessage(),
            "mensaje" => "Ocurrió un error en la base de datos.",
            "codigo " => 4,
        ]);
    }
    }
} 

