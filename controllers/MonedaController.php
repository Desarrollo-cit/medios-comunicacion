<?php

namespace Controllers;
use Exception;
use Model\Moneda;
use MVC\Router;
class MonedaController{

    public function index(Router $router)
    {
        $router->render('Moneda/index');
    }
    public function guardarAPI(){
        getHeadersApi();

        try {

            $moneda = new Moneda($_POST);
            $valor = $moneda->desc;
     
            $existe = Moneda::SQL("select * from amc_moneda where situacion =1 AND desc = '$valor'
            ");
            // echo json_encode($moneda['desc']);
            // exit;




            if (count($existe)>0){
               echo json_encode([
                   "mensaje" => "El registro ya existe.",
                   "codigo" => 2,
               ]);
               exit;
            }
             
            $resultado = $moneda->guardar();
    
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
        $moneda = Moneda::where('situacion', '0','>');
        echo json_encode($moneda);
    }




    public function modificarAPI(){
        getHeadersApi();
        $_POST["desc"] = strtoupper($_POST["desc"]);
        $moneda = new Moneda($_POST);
        $valor = $moneda->desc;
        $existe = Moneda::SQL("select * from amc_moneda where situacion =1 AND desc = '$valor'
        ");




        if (count($existe)>0){
           echo json_encode([
               "mensaje" => "El valor no se modificó.",
               "codigo" => 2,
           ]);
           exit;
        }
        $resultado = $moneda->guardar();

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
        $moneda = new Moneda($_POST);
     
        
        $resultado = $moneda->eliminar();

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
    public function cambiarSituacionAPI(){
        getHeadersApi();
        if($_POST['situacion'] == 1){
            $_POST['situacion'] = 2;
        }else{
            $_POST['situacion'] = 1;
        }
        
        $moneda = new Moneda($_POST);
        
     
        
        $resultado = $moneda->guardar();
        echo json_encode($resultado);
        exit;

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