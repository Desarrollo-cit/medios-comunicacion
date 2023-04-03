<?php

namespace Controllers;

use Model\Dinero;
use Model\Evento;
use MVC\Router;
use Exception;

class DineroController{
    public static function guardar(){
        getHeadersApi();
        hasPermissionApi(['AMC_ADMIN', 'AMC_COMANDO']);


        $cantidaddinero = count($_POST['cantidad']);

        if ($cantidaddinero == 0){

            echo json_encode([
                "mensaje" => "Debe llenar todos los campos de dinero",
                "codigo" => 5,
            ]);

            exit;


        }

    
        try {

            $evento = Evento::find($_POST['topico']);
            $evento->setInfo($_POST['info5']);
            $evento->fuente = $_POST['fuente'];
            $evento->link = $_POST['link'];
            $evento->usuario = $_POST['usuario'];
            $evento->guardar();
     

            $resultados = [];
            for ($i=0; $i < $cantidaddinero ; $i++) { 
                $migrantes = new Dinero([
                    'id' =>  $_POST['id_din'][$i] != '' ? $_POST['id_din'][$i] : null ,
                    'topic' => $_POST['topico'],
                    'cantidad' => $_POST['cantidad'][$i],
                    'moneda' => $_POST['moneda'][$i],
                    'conversion' => $_POST['conversion'][$i],
                  
                 
                ]);
                // break;
                
                $guardado = $migrantes->guardar();
                
                $resultados[] = $guardado['resultado'];
            }
//             echo json_encode($migrantes);

// exit;
            // echo json_encode($resultados);
            // exit;


            if(!array_search(0, $resultados)){
                echo json_encode([
                    "mensaje" => "El registro se guardó.",
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

public static function buscarDineroAPI(){
        getHeadersApi();
        hasPermissionApi(['AMC_ADMIN', 'AMC_COMANDO']);

        $topico = $_GET['topico'];


        try{

               
     
            $evento = Evento::find($topico);
            $evento->info = htmlspecialchars_decode($evento->info);
            $dinero = Dinero::fetchArray("SELECT * FROM amc_incautacion_dinero where topico = $topico and situacion = 1;");


            echo json_encode(  
                ['info' =>$evento,
                'dinero' => $dinero,

            
            
            ]);

        } catch (Exception $e) {
            echo json_encode([
                "detalle" => $e->getMessage(),       
                "mensaje" => "Ocurrió  un error en base de datos.",

                "codigo" => 4,
            ]);
        }
    }



    public static function modificar(){
        getHeadersApi();
        hasPermissionaPI(['AMC_ADMIN', 'AMC_COMANDO']);

 
        $cantidaddinero = count($_POST['cantidad']);

        if ($cantidaddinero == 0){

            echo json_encode([
                "mensaje" => "Debe llenar todos los campos de dinero",
                "codigo" => 5,
            ]);

            exit;


        }

    
        try {

            $evento = Evento::find($_POST['topico']);
            $evento->setInfo($_POST['info5']);
            $evento->fuente = $_POST['fuente'];
            $evento->link = $_POST['link'];
            $evento->usuario = $_POST['usuario'];
            $evento->guardar();
     

            $resultados = [];
            for ($i=0; $i < $cantidaddinero ; $i++) { 
                $migrantes = new Dinero([
                    'id' =>  $_POST['id_din'][$i] != '' ? $_POST['id_din'][$i] : null ,
                    'topic' => $_POST['topico'],
                    'cantidad' => $_POST['cantidad'][$i],
                    'moneda' => $_POST['moneda'][$i],
                    'conversion' => $_POST['conversion'][$i],
                  
                 
                ]);
                // break;
                
                $guardado = $migrantes->guardar();
                
                $resultados[] = $guardado['resultado'];
            }
//             echo json_encode($migrantes);

// exit;
            // echo json_encode($resultados);
            // exit;


            if(!array_search(0, $resultados)){
                echo json_encode([
                    "mensaje" => "El registro se modifico.",
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

    public static function eliminarDinero(){
        getHeadersApi();
        hasPermissionApi(['AMC_ADMIN', 'AMC_COMANDO']);

        
        
        
        try {
            $dinero = Dinero::find($_POST['id']);
            $dinero->situacion = 0;
            $resultado = $dinero->guardar();
    
            if($resultado['resultado'] == 1){
                echo json_encode([
                    "mensaje" => "El registro del migrante se eliminó.",
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

    public static function eliminarDineros(){
        getHeadersApi();
        hasPermissionApi(['AMC_ADMIN', 'AMC_COMANDO']);

        
        
        try {

            $topico = $_POST['topico'];
            // ELIMINA EL TOPICO
            $evento = Evento::find($topico);
            $evento->situacion = 0;
            $evento->guardar();

            $dinero = Dinero::where('topico', $topico);
            $resultados = [];
            foreach($dinero as $din){
                $din->situacion = 0;
                $resultados[] = $din->guardar();
            }

    
            if(!array_search(0, $resultados)){
                echo json_encode([
                    "mensaje" => "El Incidente de Dinero se elimino",
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

}