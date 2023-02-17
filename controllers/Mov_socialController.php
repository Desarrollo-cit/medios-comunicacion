<?php

namespace Controllers;

use Model\Mov_social;
use Model\Evento;
use MVC\Router;
use Exception;


class Mov_socialController{
    public static function guardar(){
        getHeadersApi();



    
        try {

            $evento = Evento::find($_POST['topico']);
            $evento->info = $_POST['info8'];
            $evento->guardar();
     

            $resultados = [];

                $movimiento = new Mov_social([
                    'id' =>  $_POST['id']!= '' ? $_POST['id']: null ,
                    'topico' => $_POST['topico'],
                    'tipo_movimiento' => $_POST['tipo_movimiento'],
                    'organizacion' => $_POST['organizacion'],
                    'cantidad' => $_POST['cantidad'],
            

                  
                 
                ]);

                
                $guardado = $movimiento->guardar();
                
                $resultados[] = $guardado['resultado'];
           


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

public static function buscarMovimientoAPI(){
    getHeadersApi();
    $topico = $_GET['topico'];
    // echo json_encode("hola");
    // exit;



  

        try{

               
     
            $evento = Evento::find($topico);

            $movimiento = Mov_social::fetchArray("SELECT * FROM amc_movimiento_social where topico = $topico and situacion = 1;");


            echo json_encode(  
                ['info' =>$evento,
                'movimiento' => $movimiento,

            
            
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

 
        
        try {

            $evento = Evento::find($_POST['topico']);
            $evento->info = $_POST['info8'];
            $evento->guardar();
     

            $resultados = [];

                $movimiento = new Mov_social([
                    'id' =>  $_POST['id']!= '' ? $_POST['id']: null ,
                    'topico' => $_POST['topico'],
                    'tipo_movimiento' => $_POST['tipo_movimiento'],
                    'organizacion' => $_POST['organizacion'],
                    'cantidad' => $_POST['cantidad'],
            

                  
                 
                ]);

                
                $guardado = $movimiento->guardar();
                
                $resultados[] = $guardado['resultado'];
           


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



    public static function eliminarMovimiento(){
        getHeadersApi();
        
        
        try {

            $topico = $_POST['topico'];
            // ELIMINA EL TOPICO
            $evento = Evento::find($topico);
            $evento->situacion = 0;
            $evento->guardar();

            $movimiento = Mov_social::where('topico', $topico);
            $resultados = [];
            foreach($movimiento as $mov){
                $mov->situacion = 0;
                $resultados[] = $mov->guardar();
            }

    
            if(!array_search(0, $resultados)){
                echo json_encode([
                    "mensaje" => "El Incidente de Movimientos Sociales se elimino",
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