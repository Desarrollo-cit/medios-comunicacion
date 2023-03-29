<?php

namespace Controllers;

use Model\Actividad_vinculada;
use MVC\Router;

class Actividad_vinculadaController{

    // public static function index(Router $router)
    // { 
    //     hasPermission(['AMC_ADMIN']);

    //     $router->render('Actividad_vinculada/index');
    // }

    public static function index(Router $router){
        $router->render('actividad_vinculada/index');

    }

    public static function guardarAPI(){
        getHeadersApi();
        hasPermissionApi(['AMC_ADMIN']);
        try {
            // $_POST["desc"] = strtoupper($_POST["desc"]);
            $Actividad_vinculada = new Actividad_vinculada($_POST);
            $valor = $Actividad_vinculada->desc;
            $existe = Actividad_vinculada::SQL("SELECT * from amc_actividad_vinculada where situacion =1 AND desc = '$valor'");
            
            // echo json_encode($existe);
            // exit;
            if (count($existe)>0){
               echo json_encode([
                   "mensaje" => "El registro ya existe",
                   "codigo" => 2,
               ]);
               exit;
            }
             
            $resultado = $Actividad_vinculada->guardar();
    
            if($resultado['resultado'] == 1){
                echo json_encode([
                    "mensaje" => "El registro se guardo",
                    "codigo" => 1,
                ]);
                
            }else{
                echo json_encode([
                    "mensaje" => "Ocurrió un error",
                    "codigo" => 0,
                ]);
    
            }
        } catch (Exception $e) {
            echo json_encode([
                "detalle" => $e->getMessage(),       
                "mensaje" => "Ocurrió un error en base de datos",

                "codigo" => 4,
            ]);
        }
        
    }

    public static function buscarApi(){
        getHeadersApi();
        hasPermissionApi(['AMC_ADMIN']);
        $Actividad_vinculada = Actividad_vinculada::where('situacion', '0','>');
        echo json_encode($Actividad_vinculada);
    }

    public static function modificarAPI(){
        getHeadersApi();
        hasPermissionApi(['AMC_ADMIN']);

       try {
            // $_POST["desc"] = strtoupper($_POST["desc"]);
            $Actividad_vinculada = new Actividad_vinculada($_POST);
            $valor = $Actividad_vinculada->desc;
            $existe = Actividad_vinculada::SQL("select * from amc_actividad_vinculada where situacion =1 AND desc = '$valor'");
            if (count($existe)>0){
               echo json_encode([
                   "mensaje" => "El valor no se modificó.",
                   "codigo" => 2,
               ]);
               exit;
            }
             
            $resultado = $Actividad_vinculada->guardar();
    
            if($resultado['resultado'] == 1){
                echo json_encode([
                    "mensaje" => "El registro se guardo",
                    "codigo" => 1,
                ]);
                
            }else{
                echo json_encode([
                    "mensaje" => "Ocurrió un error",
                    "codigo" => 0,
                ]);
    
            }
        } catch (Exception $e) {
            echo json_encode([
                "detalle" => $e->getMessage(),       
                "mensaje" => "Ocurrió un error en base de datos",

                "codigo" => 4,
            ]);
        }
    }

    public static function eliminarAPI(){
        getHeadersApi();
        hasPermissionApi(['AMC_ADMIN']);

        $_POST['situacion'] = 0;
        $Actividad_vinculada = new Actividad_vinculada($_POST);
        
        $resultado = $Actividad_vinculada->guardar();

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
        getHeadersApi();
        hasPermissionApi(['AMC_ADMIN']);
    if ($_POST['situacion'] == 1){
        $_POST['situacion'] = 2;
    }else{
        $_POST['situacion'] = 1;

        }
        $Actividad_vinculada = new Actividad_vinculada($_POST);
        $resultado = $Actividad_vinculada->guardar();
        if($resultado['resultado'] == 1){
            echo json_encode([
                "resultado" => 1
            ]);
            
        }else{
            echo json_encode([
                "resultado" => 2
            ]);

        }
    }
} 


