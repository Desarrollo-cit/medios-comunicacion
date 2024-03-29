<?php

namespace Controllers;

use Model\Calibres;
use MVC\Router;
class CalibresController{

    public static function index(Router $router)
    {
        $router->render('calibres/index');
        hasPermission(['AMC_ADMIN']);

    }

    public static function guardarAPI(){
        getHeadersApi();
        hasPermissionApi(['AMC_ADMIN']);


        try {
            $_POST["desc"] = strtoupper($_POST["desc"]);
            $calibres = new Calibres($_POST);
            $valor = $calibres->desc;
            $existe = Calibres::SQL("select * from amc_calibre where situacion =1 AND desc = '$valor'");
            if (count($existe)>0){
               echo json_encode([
                   "mensaje" => "El registro ya existe",
                   "codigo" => 2,
               ]);
               exit;
            }
             
            $resultado = $calibres->guardar();
    
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

        $calibres = Calibres::where('situacion', '0','>');
        echo json_encode($calibres);
    }

    public static function modificarAPI(){
        getHeadersApi();
        hasPermissionApi(['AMC_ADMIN']);
       try {
            // $_POST["desc"] = strtoupper($_POST["desc"]);
            $calibres = new Calibres($_POST);
            $valor = $calibres->desc;
            $existe = Calibres::SQL("select * from amc_calibre where situacion =1 AND desc = '$valor'");
            if (count($existe)>0){
               echo json_encode([
                   "mensaje" => "No se modificó el valor.",
                   "codigo" => 2,
               ]);
               exit;
            }
             
            $resultado = $calibres->guardar();
    
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
        $calibres = new Calibres($_POST);
        
        $resultado = $calibres->guardar();

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
    public static function cambiarSituacionAPI(){
        getHeadersApi();
        hasPermissionApi(['AMC_ADMIN']);

        if($_POST['situacion'] == 1){
            $_POST['situacion']=2;
        }else{
            $_POST['situacion']=1;

        }
        $calibres = new Calibres($_POST);
        $resultado = $calibres->guardar();
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

