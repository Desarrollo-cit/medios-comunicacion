<?php

namespace Controllers;
use Exception;
use Model\Desastre_natural;
use MVC\Router;
class Desastre_naturalController{

    public static function index(Router $router)
    {
        hasPermission(['AMC_ADMIN']);

        $router->render('desastre_natural/index');
    }
    public static function guardarAPI(){
        getHeadersApi();
        hasPermissionApi(['AMC_ADMIN']);

        try {
            $desastre = new Desastre_natural($_POST);
            $valor = $desastre->desc;
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

    public static function buscarApi(){
        getHeadersApi();
        hasPermissionApi(['AMC_ADMIN']);

        $desastre = Desastre_natural::where('situacion', '1');
        echo json_encode($desastre);
    }




    public static function modificarAPI(){
        getHeadersApi();
        hasPermissionApi(['AMC_ADMIN']);

        $desastre = new Desastre_natural($_POST);
        $valor = $desastre->desc;
        $existe = Desastre_natural::SQL("select * from amc_tipo_desastre_natural where situacion =1 AND desc = '$valor'");




        if (count($existe)>0){
            echo json_encode([
                "mensaje" => "El valor no se modificó.",
                "codigo" => 2,
            ]);
            exit;
        }
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

    public static function eliminarAPI(){
        getHeadersApi();
        hasPermissionApi(['AMC_ADMIN']);

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
