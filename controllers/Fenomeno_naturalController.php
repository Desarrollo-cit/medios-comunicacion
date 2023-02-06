<?php

namespace Controllers;
use Exception;
use Model\Fenomeno_natural;
use MVC\Router;
class Fenomeno_naturalController{

    public function index(Router $router)
    {
        $router->render('fenomeno_natural/index');
    }
    public function guardarAPI(){
        getHeadersApi();

        try {
            $_POST["desc"] = strtoupper($_POST["desc"]);
            $fenomeno = new Fenomeno_natural($_POST);
            $valor = $_POST["desc"];
            $existe = Fenomeno_natural::SQL("select * from amc_fenomeno_natural where situacion =1 AND desc = '$valor'
            ");




            if (count($existe)>0){
               echo json_encode([
                   "mensaje" => "El registro ya existe.",
                   "codigo" => 2,
               ]);
               exit;
            }
             
            $resultado = $fenomeno->guardar();
    
            if($resultado['resultado'] == 1){
                echo json_encode([
                    "mensaje" => "El registro se guardo.",
                    "codigo" => 1,
                ]);
                
            }else{
                echo json_encode([
                    "mensaje" => "Ocurrió  un error.",
                    "codigo" => 0,
                ]);
    
            }
        } catch (Exception $e) {
            echo json_encode([
                "detalle" => $e->getMessage(),       
                "mensaje" => "Ocurrió  un error en base de datos.",

                "codigo" => 4,
            ]);
        }
        
    }

    public function buscarApi(){
        getHeadersApi();
        $fenomeno = Fenomeno_natural::where('situacion', '1');
        echo json_encode($fenomeno);
    }




    public function modificarAPI(){
        getHeadersApi();
        $_POST["desc"] = strtoupper($_POST["desc"]);
        $fenomeno = new Fenomeno_natural($_POST);
        
        $resultado = $fenomeno->guardar();

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
        $fenomeno = new Fenomeno_natural($_POST);
     
        
        $resultado = $fenomeno->eliminar();

        if($resultado == 1){
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

?>