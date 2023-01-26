<?php

namespace Controllers;

use Exception;
use Model\Organizacion;
use MVC\Router;
class OrganizacionController{

    public function index(Router $router)
    {
        $router->render('organizacion/index');
    }

    public function guardarAPI(){
        getHeadersApi();
        try {
            $_POST["desc"] = strtoupper($_POST["desc"]);
            $tipo = new Organizacion($_POST);
            $dato = $_POST["desc"];
            $existe = Organizacion::SQL("SELECT * FROM amc_organizacion_mov_social where desc = '$dato' and situacion = 1 ");
            if (count($existe)>0){
               echo json_encode([
                   "mensaje" => "el registro ya existe",
                   "codigo" => 2,
               ]);
               exit;
            }
             
            $resultado = $tipo->guardar();
            // echo json_encode($resultado['resultado']);
    
            if($resultado['resultado'] == 1){
                echo json_encode([
                    "mensaje" => "el registro se guardo",
                    "codigo" => 1,
                ]);
                
            }else{
                echo json_encode([
                    "mensaje" => "ocurrio un error",
                    "codigo" => 0,
                ]);
    
            }
        } catch (Exception $e) {
            echo json_encode([
                "detalle" => $e->getMessage(),       
                "mensaje" => "ocurrio un error en base de datos",

                "codigo" => 4,
            ]);
        }
        
    }


    public function buscarApi(){
        try {
            getHeadersApi();
            $Organizacion = Organizacion::where('situacion', '1');
            echo json_encode($Organizacion);       
        } catch (Exception $e) {
            echo json_encode(["error"=>$e->getMessage()]);
        }
       
    }

    public function modificarAPI(){
        $_POST["desc"] = strtoupper($_POST["desc"]);
        getHeadersApi();
        $Organizacion = new Organizacion($_POST);
        
        $resultado = $Organizacion->guardar();

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

    public function eliminarAPI(){
        getHeadersApi();
        $_POST['situacion'] = 0;
        $Organizacion = new Organizacion($_POST);
        
        $resultado = $Organizacion->eliminar();

        if($resultado['resultado'] == 1){
            echo json_encode([
                "resultado" => 0
            ]);
            
        }else{
            echo json_encode([
                "resultado" => 1
            ]);

        }
    }
} 

