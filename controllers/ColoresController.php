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


public static function buscarApi(){
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

public static function modificarAPI(){
    try {
        getHeadersApi();

        // echo json_encode($_POST);
        // exit;

        // $_POST["descripcion"] = strtoupper($_POST["descripcion"]);
        $colores = new Colores($_POST);

        $cantidad = $_POST['cantidad'];

        $topico = $_POST['topico'];
        $id = $_POST['id'];
        $nivel = $_POST['nivel'];



        $cantidades = Colores::fetchArray("SELECT cantidad from amc_colores where topico = $topico and nivel > $nivel ");
        $cantidadesMenores = Colores::fetchArray("SELECT cantidad from amc_colores where topico = $topico and nivel < $nivel ");
        // echo json_encode($cantidades);
        // exit;

        $validaciones = true;
        foreach ($cantidades as $key => $c) {
            if( $cantidad >= $c['cantidad'] ){
                $validaciones = false;
                
                echo json_encode([
                    "mensaje" => "NO SE PUEDE MODIFICAR, NO RESPETA LOS NIVELES.",
                    "codigo" => 6,
                ]);
                break;
            }
        }

        foreach ($cantidadesMenores as $key => $c) {
            if( $cantidad <= $c['cantidad'] ){
                $validaciones = false;

                echo json_encode([
                    "mensaje" => "NO SE PUEDE MODIFICAR, NO RESPETA LOS NIVELES.",
                    "codigo" => 6,
                ]);
                break;
            }
        }

        if($validaciones == true){

                $resultado = $colores->guardar();
    
                if($resultado['resultado'] == 1){
                    echo json_encode([
                        "mensaje" => "El registro se modificó.",
                        "codigo" => 1,
                    ]);
                    
                }else{
                    echo json_encode([
                        "mensaje" => "Ocurrio un error.",
                        "codigo" => 0,
                    ]);
        
                }
    
            }
    


    
    } catch (Exception $e) {
        echo json_encode([
            "detalle" => $e->getMessage(),       
            "mensaje" => "Ocurrio un error en base de datos.", 
            "codigo" => 4,
        ]);
    }
}




}

