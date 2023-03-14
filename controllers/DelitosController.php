<?php

namespace Controllers;

use Model\Delitos;
use MVC\Router;
class DelitosController{

    public static function index(Router $router)
    {
        hasPermission(['AMC_ADMIN']);
        $router->render('delitos/index');
    }

    public static function guardarAPI(){
        getHeadersApi();
        hasPermissionApi(['AMC_ADMIN']);


        try {
            // $_POST["desc"] = strtoupper($_POST["desc"]);
            $delitos = new Delitos($_POST);
            $valor = $delitos->desc;
            $existe = Delitos::SQL("select * from amc_delito where situacion =1 AND desc = '$valor'");
            if (count($existe)>0){
               echo json_encode([
                   "mensaje" => "El registro ya existe",
                   "codigo" => 2,
               ]);
               exit;
            }
             
            $resultado = $delitos->guardar();
    
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
        $delitos = Delitos::where('situacion', '1');
        echo json_encode($delitos);
    }

    public static function modificarAPI(){
        getHeadersApi();
        hasPermissionApi(['AMC_ADMIN']);

       try {
            $_POST["desc"] = strtoupper($_POST["desc"]);
            $delitos = new Delitos($_POST);
            $valor = $delitos->desc;
            $existe = Delitos::SQL("select * from amc_delito where situacion =1 AND desc = '$valor'");
            if (count($existe)>0){
               echo json_encode([
                   "mensaje" => "El registro ya existe",
                   "codigo" => 2,
               ]);
               exit;
            }
             
            $resultado = $delitos->guardar();
    
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
        $delitos = new Delitos($_POST);
        
        $resultado = $delitos->guardar();

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

        // echo($_POST['situacion']);
    if ($_POST['situacion'] == 1){
        $_POST['situacion'] = 2;
    }else{
        $_POST['situacion'] = 1;

        }
        $delitos = new delitos($_POST);
        $resultado = $delitos->guardar();
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

