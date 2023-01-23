<?php

namespace Controllers;

use Model\Calibres;
use MVC\Router;
class CalibresController{

    public function index(Router $router)
    {
        $router->render('calibres/index');
    }

    public function guardarAPI(){
        getHeadersApi();

        try {
            $_POST["desc"] = strtoupper($_POST["desc"]);
            $calibres = new Calibres($_POST);
            $valor = $_POST["desc"];
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

    public function buscarApi(){
        getHeadersApi();
        $calibres = Calibres::where('situacion', '1');
        echo json_encode($calibres);
    }

    public function modificarAPI(){
        getHeadersApi();
       try {
            $_POST["desc"] = strtoupper($_POST["desc"]);
            $calibres = new Calibres($_POST);
            $valor = $_POST["desc"];
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

    public function eliminarAPI(){
        getHeadersApi();
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
} 

