<?php

namespace Controllers;

use Model\Armas;
use MVC\Router;
class ArmasController{

    public function index(Router $router)
    {
        $router->render('armas/index');
    }

    public function guardarAPI(){
        getHeadersApi();

        try {
            // $_POST["desc"] = strtoupper($_POST["desc"]);
            $armas = new Armas($_POST);
            $valor = $armas->desc;
            $existe = Armas::SQL("SELECT * from amc_tipo_armas where situacion =1 AND desc = '$valor'");
            
            // echo json_encode($existe);
            // exit;
            if (count($existe)>0){
               echo json_encode([
                   "mensaje" => "El registro ya existe",
                   "codigo" => 2,
               ]);
               exit;
            }
             
            $resultado = $armas->guardar();
    
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
        $armas = Armas::where('situacion', '1');
        echo json_encode($armas);
    }

    public function modificarAPI(){
        getHeadersApi();
       try {
            // $_POST["desc"] = strtoupper($_POST["desc"]);
            $armas = new Armas($_POST);
            $valor = $armas->desc;
            $existe = Armas::SQL("select * from amc_tipo_armas where situacion =1 AND desc = '$valor'");
            if (count($existe)>0){
               echo json_encode([
                   "mensaje" => "El valor no se modificó.",
                   "codigo" => 2,
               ]);
               exit;
            }
             
            $resultado = $armas->guardar();
    
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
        $armas = new Armas($_POST);
        
        $resultado = $armas->guardar();

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

