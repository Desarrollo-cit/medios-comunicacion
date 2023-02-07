<?php

namespace Controllers;
use Exception;
use Model\Desastre_natural;
use MVC\Router;
class Desastre_naturalController{

    public function index(Router $router)
    {
        $router->render('desastre_natural/index');
    }
    public function guardarAPI(){
        getHeadersApi();

        try {
            $desastre = new Desastre_natural($_POST);
            $valor = $_POST["desc"];
            $existe = Desastre_natural::SQL("select * from amc_tipo_desastre_natural where situacion =1 AND desc = '$valor'
            ");




            if (count($existe)>0){
               echo json_encode([
                   "mensaje" => "El registro ya existe.",
                   "codigo" => 2,
               ]);
               exit;
            }
             
            $resultado = $desastre->guardar();
    
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
        $desastre = Desastre_natural::where('situacion', '1');
        echo json_encode($desastre);
    }




    public function modificarAPI(){
        getHeadersApi();
        $_POST["desc"] = strtoupper($_POST["desc"]);
        $desastre = new Desastre_natural($_POST);
        
        $resultado = $desastre->guardar();

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
        $desastre = new Desastre_natural($_POST);
     
        
        $resultado = $desastre->eliminar();

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