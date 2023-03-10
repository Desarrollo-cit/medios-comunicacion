<?php

namespace Controllers;

use Exception;
use Model\Tipo;
use MVC\Router;
class TipoController{

    public function index(Router $router)
    {        hasPermission(['AMC_ADMIN']);

        $router->render('tipo/index');
    }


    public function guardarAPI(){
        getHeadersApi();
        hasPermissionApi(['AMC_ADMIN']);

        try {

            $tipo = new Tipo($_POST);
            $dato = $_POST["desc"];
            $existe = Tipo::SQL("SELECT * FROM amc_tipo_movimiento_social where desc = '$dato' and situacion = 1 ");
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
        hasPermissionApi(['AMC_ADMIN']);

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
        hasPermissionApi(['AMC_ADMIN']);

        try {
            $_POST["desc"] = strtoupper($_POST["desc"]);
            $Tipo = new Tipo($_POST);
            
            $resultado = $Tipo->guardar();
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
        hasPermissionApi(['AMC_ADMIN']);

        $_POST['situacion'] = 0;
        $Tipo = new Tipo($_POST);
        
        $resultado = $Tipo->eliminar();

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

