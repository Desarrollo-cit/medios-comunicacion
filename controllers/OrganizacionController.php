<?php

namespace Controllers;

use Exception;
use Model\Organizacion;
use MVC\Router;
class OrganizacionController{

    public function index(Router $router)
    {
        hasPermission(['AMC_ADMIN']);
        $router->render('organizacion/index');
    }

    public function guardarAPI(){
        getHeadersApi();
        hasPermissionApi(['AMC_ADMIN']);
        try {

            $tipo = new Organizacion($_POST);
            $dato = $tipo->desc;
            $existe = Organizacion::SQL("SELECT * FROM amc_organizacion_mov_social where desc = '$dato' and situacion = 1 ");
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
                "mensaje" => "Ocurrió un error en base de datos.",

                "codigo" => 4,
            ]);
        }
        
    }


    public function buscarApi(){
        hasPermissionApi(['AMC_ADMIN']);
        try {
            getHeadersApi();
            $Organizacion = Organizacion::where('situacion', '1');
            echo json_encode($Organizacion);       
        } catch (Exception $e) {
            echo json_encode(["error"=>$e->getMessage()]);
        }
       
    }

    public function modificarAPI(){
        hasPermissionApi(['AMC_ADMIN']);
        try {
            getHeadersApi();
            $Organizacion = new Organizacion($_POST);
            $dato = $Organizacion->desc;
            $existe = Organizacion::SQL("SELECT * FROM amc_organizacion_mov_social where desc = '$dato' and situacion = 1 ");
            if (count($existe)>0){
               echo json_encode([
                   "mensaje" => "El registro ya existe.",
                   "codigo" => 2,
               ]);
               exit;
            }
            $resultado = $Organizacion->guardar();
            
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

