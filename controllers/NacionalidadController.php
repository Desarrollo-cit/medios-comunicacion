<?php

namespace Controllers;

use Exception;
use Model\Nacionalidad;
use MVC\Router;
class NacionalidadController{

    public function index(Router $router)
    {
        $busqueda=  Nacionalidad::fetchArray('SELECT * FROM paises');
        $router->render('nacionalidad/index',[

            'busqueda' => $busqueda,
        ]);
    }

    public function guardarAPI(){
        getHeadersApi();
        $Nacionalidad = new Nacionalidad($_POST);
        
        $resultado = $Nacionalidad->guardar();

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
            $nacionalidad = Nacionalidad::fetchArray('SELECT amc_nacionalidad.id, amc_nacionalidad.desc, paises.pai_desc_lg as pais from amc_nacionalidad inner join paises on amc_nacionalidad.pais = paises.pai_codigo');
            echo json_encode($nacionalidad);       
        } catch (Exception $e) {
            echo json_encode(["error"=>$e->getMessage()]);
        }
       
    }

    public function modificarAPI(){
        getHeadersApi();
        $Nacionalidad = new Nacionalidad($_POST);
        
        $resultado = $Nacionalidad->guardar();

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
        $Nacionalidad = new Nacionalidad($_POST);
        
        $resultado = $Nacionalidad->guardar();

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

