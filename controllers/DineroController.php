<?php

namespace Controllers;

use Model\Dinero;
use Model\Evento;
use MVC\Router;
use Exception;

class DineroController{
    public static function guardar(){
        getHeadersApi();


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
            $evento->info = $_POST['info5'];
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

        $topico = $_GET['topico'];


        try{

               
     
            $evento = Evento::find($topico);

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

 
    
        $cantidadmigrantes = count($_POST['edad']);
        
        try {

            $evento = Evento::find($_POST['topic']);
            $evento->info = $_POST['info3'];
            $evento->guardar();
     

            $resultados = [];
            for ($i=0; $i < $cantidadmigrantes ; $i++) { 
                $migrantes = new Dinero([
                    'id' =>  $_POST['id_mig'][$i] != '' ? $_POST['id_mig'][$i] : null ,
                    'topic' => $_POST['topic'],
                    'pais_migrante' => $_POST['pais_migrante'][$i],
                    'edad' => $_POST['edad'][$i],
                    'cantidad' => $_POST['cantidad'][$i],
                    'sexo' => $_POST['sexo'][$i],
                    'lugar_ingreso' => $_POST['lugar_ingreso'][$i],
                    'destino' => $_POST['destino'][$i],
                    
                 
                ]);
                // break;
                
                $guardado = $migrantes->guardar();
                
                $resultados[] = $guardado['resultado'];
            }


            if(!array_search(0, $resultados)){
                echo json_encode([
                    "mensaje" => "El registro se modificó.",
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

    public static function eliminarMigrante(){
        getHeadersApi();


        
        
        
        try {
            $migrante = Dinero::find($_POST['id']);
            $migrante->situacion = 0;
            $resultado = $migrante->guardar();
    
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

    public static function eliminarMigrantes(){
        getHeadersApi();
        
        
        try {

            $topico = $_POST['topic'];
            // ELIMINA EL TOPICO
            $evento = Evento::find($topico);
            $evento->situacion = 0;
            $evento->guardar();

            $migrante = Dinero::where('topic', $topico);
            $resultados = [];
            foreach($migrante as $migran){
                $migran->situacion = 0;
                $resultados[] = $migran->guardar();
            }

    
            if(!array_search(0, $resultados)){
                echo json_encode([
                    "mensaje" => "Los Migrantes se eliminaron.",
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