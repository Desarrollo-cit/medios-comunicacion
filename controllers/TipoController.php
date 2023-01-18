<?php

namespace Controllers;

use Exception;
use Model\Tipo;
use MVC\Router;
class TipoController{

    public function index(Router $router)
    {
        $router->render('tipo/index');
    }

    public function guardarAPI(){
        getHeadersApi();
        $Tipo = new Tipo($_POST);
        
        $resultado = $Tipo->guardar();

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

    public function buscarApi(){
        try {
            getHeadersApi();
            $Tipo = Tipo::where('situacion', '1');
            echo json_encode($Tipo);       
        } catch (Exception $e) {
            echo json_encode(["error"=>$e->getMessage()]);
        }
       
    }

    public function modificarAPI(){
        getHeadersApi();
        $Tipo = new Tipo($_POST);
        
        $resultado = $Tipo->guardar();

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
        $Tipo = new Tipo($_POST);
        
        $resultado = $Tipo->guardar();

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

