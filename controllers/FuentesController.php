<?php

namespace Controllers;

use Model\Fuentes;
use MVC\Router;
class FuentesController{

    public static function index(Router $router)
    {
        $router->render('Fuentes/index');
    }

    public static function guardarAPI(){
        getHeadersApi();

        try {
            // $_POST["desc"] = strtoupper($_POST["desc"]);
            $Fuentes = new Fuentes($_POST);
            $valor = $Fuentes->desc;
            $existe = Fuentes::SQL("SELECT * from amc_fuentes where situacion = 1 AND desc = '$valor'");
            
            // 
            if (count($existe)>0){
               echo json_encode([
                   "mensaje" => "El registro ya existe",
                   "codigo" => 2,
               ]);
               exit;
            }
             
            $resultado = $Fuentes->guardar();
            // echo json_encode($resultado);
            // exit;

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
        $Fuentes = Fuentes::where('situacion', '0', '>');
        echo json_encode($Fuentes);
    }

    public static function modificarAPI(){
        getHeadersApi();
       try {
            // $_POST["desc"] = strtoupper($_POST["desc"]);
            $Fuentes = new Fuentes($_POST);
            $valor = $Fuentes->desc;
            $existe = Fuentes::SQL("select * from amc_fuentes where situacion =1 AND desc = '$valor'");
            if (count($existe)>0){
               echo json_encode([
                   "mensaje" => "El valor no se modificó.",
                   "codigo" => 2,
               ]);
               exit;
            }
             
            $resultado = $Fuentes->guardar();
    
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
        $_POST['situacion'] = 0;
        $Fuentes = new Fuentes($_POST);
        
        $resultado = $Fuentes->guardar();

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
        // echo($_POST['situacion']);
    if ($_POST['situacion'] == 1){
        $_POST['situacion'] = 2;
    }else{
        $_POST['situacion'] = 1;

        }
        $Fuentes = new Fuentes($_POST);
        $resultado = $Fuentes->guardar();
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