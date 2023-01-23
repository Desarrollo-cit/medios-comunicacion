<?php

namespace Controllers;
use MVC\Router;
use Exception;
use Model\Colores;
 
class ColoresController{

public static function index(Router $router){
    $busqueda = Colores::fetchArray('SELECT * FROM amc_tipo_topics');
    $router->render('colores/index',[

        'busqueda'=> $busqueda,
    ]);
}

public function guardarAPI(){

    try {
        getHeadersApi();
        $colores = new Colores($_POST);
        
        $resultado = $colores->guardar();

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
        //code...
    } catch (Exception $e) {
        echo json_encode([
            "detalle" => $e->getMessage(),       
            "mensaje" => "ocurrio un error en base de datos",

            "codigo" => 4,
        ]);
    }
}
public function buscarApi(){
    $topico= $_GET['topico'];
  
    
    // echo json_encode($_GET);
    try {
        getHeadersApi();

      
        $armas = Colores::fetchArray("SELECT amc_colores.id, amc_colores.descripcion, amc_colores.cantidad,amc_colores.color, amc_colores.nivel, amc_colores.topico, amc_tipo_topics.desc from amc_colores inner join amc_tipo_topics on amc_tipo_topics.id = amc_colores.topico where amc_colores.situacion = 1 and amc_colores.topico= $topico");
        echo json_encode($armas);        } 
        
        catch (Exception $e) {
            echo json_encode(["error" => $e->getMessage()]);
        }
    
}

public function modificarAPI(){
    try {
        getHeadersApi();
        $colores = new Colores($_POST);

        // echo json_encode($_POST);
        // exit;
        
        $resultado = $colores->guardar();

        if($resultado['resultado'] == 1){
            echo json_encode([
                "mensaje" => "el registro se modifico",
                "codigo" => 1,
            ]);
            
        }else{
            echo json_encode([
                "mensaje" => "ocurrio un error",
                "codigo" => 0,
            ]);

        }
        //code...
    } catch (Exception $e) {
        echo json_encode([
            "detalle" => $e->getMessage(),       
            "mensaje" => "ocurrio un error en base de datos", 
            "codigo" => 4,
        ]);
    }
}

public function eliminarAPI(){


    try {
            getHeadersApi();
        $colores = new Colores($_POST);
    
        $resultado = $colores->eliminar();

        // echo json_encode($resultado);
        // exit;

    if($resultado == 1){
        echo json_encode([
            "mensaje" => "el registro se elimino",
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


}

