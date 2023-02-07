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

        try {
           // $_POST["desc"] = strtoupper($_POST["desc"]);
            $tipo = new Nacionalidad($_POST);
            $dato = $_POST["desc"];
            $existe = Nacionalidad::SQL("SELECT * FROM amc_nacionalidad where desc = '$dato' and situacion = 1 ");
            if (count($existe)>0){
               echo json_encode([
                   "mensaje" => "El registro ya existe.",
                   "codigo" => 2,
               ]);
               exit;
            }
             
            $resultado = $tipo->guardar();
            // echo json_encode($resultado['resultado']);
    
            if($resultado['resultado'] == 1){
                echo json_encode([
                    "mensaje" => "El registro se guardó correctamente.",
                    "codigo" => 1,
                ]);
                
            }else{
                echo json_encode([
                    "mensaje" => "Ocurrió un error.",
                    "codigo" => 0,
                ]);
    
            }
        } catch (Exception $e) {
            echo json_encode([
                "detalle" => $e->getMessage(),       
                "mensaje" => "Ocurrió un error en la base de datos.",

                "codigo" => 4,
            ]);
        }
        
    }


    public function buscarApi(){
        try {
            getHeadersApi();
            $nacionalidad = Nacionalidad::fetchArray('SELECT amc_nacionalidad.id, amc_nacionalidad.desc, paises.pai_desc_lg as pais, paises.pai_codigo as idpais from amc_nacionalidad inner join paises on amc_nacionalidad.pais = paises.pai_codigo');
            echo json_encode($nacionalidad);       
        } catch (Exception $e) {
            echo json_encode(["error"=>$e->getMessage()]);
        }
       
    }

    public function modificarAPI(){
        getHeadersApi();
        try {
            $_POST["desc"] = strtoupper($_POST["desc"]);
            $Nacionalidad = new Nacionalidad($_POST);
            
            $resultado = $Nacionalidad->guardar();
         
    
            if($resultado['resultado'] == 1){
                echo json_encode([
                    "mensaje" => "El registro se guardó correctamente.",
                    "codigo" => 1,
                ]);
                
            }else{
                echo json_encode([
                    "mensaje" => "Ocurrió un error.",
                    "codigo" => 0,
                ]);
    
            }
        } catch (Exception $e) {
            echo json_encode([
                "detalle" => $e->getMessage(),       
                "mensaje" => "Ocurrió un error en la base de datos.",

                "codigo" => 4,
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

