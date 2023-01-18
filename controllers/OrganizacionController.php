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
} 

