<?php

namespace Controllers;

use Model\Pistas;
use Model\Evento;
use MVC\Router;
use Exception;
use Model\Desastre_natural;

class PistasController{
    public static function guardar(){
        getHeadersApi();



    
        try {

            $evento = Evento::find($_POST['topico']);
            $evento->setInfo($_POST['info7']);
            $evento->fuente = $_POST['fuente'];
            $evento->link = $_POST['link'];
            $evento->usuario = $_POST['usuario'];
            $evento->guardar();
     

            $resultados = [];

                $desastres = new Pistas([
                    'id' =>  $_POST['id']!= '' ? $_POST['id']: null ,
                    'topico' => $_POST['topico'],
                    'distancia' => $_POST['distancia'],
                   

                  
                 
                ]);

                
                $guardado = $desastres->guardar();
                
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

public static function buscarPistasAPI(){

    getHeadersApi();
    $topico = $_GET['topico'];
    // echo json_encode("hola");
    // exit;



  

        try{

               
     
            $evento = Evento::find($topico);
            $evento->info = htmlspecialchars_decode($evento->info);
            $pista =Pistas::fetchArray("SELECT * FROM amc_destruccion_pista where topico = $topico and situacion = 1;");


            echo json_encode(  
                ['info' =>$evento,
                'pista' => $pista,

            
            
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
            $evento->setInfo($_POST['info7']);
            $evento->fuente = $_POST['fuente'];
            $evento->link = $_POST['link'];
            $evento->usuario = $_POST['usuario'];
            $evento->guardar();
     

            $resultados = [];

                $desastres = new Pistas([
                    'id' =>  $_POST['id']!= '' ? $_POST['id']: null ,
                    'topico' => $_POST['topico'],
                    'distancia' => $_POST['distancia'],
                   

                  
                 
                ]);

                
                $guardado = $desastres->guardar();
                
                $resultados[] = $guardado['resultado'];
           


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



    public static function eliminarPistas(){
        getHeadersApi();
        
        
        try {

            $topico = $_POST['topico'];
            // ELIMINA EL TOPICO
            $evento = Evento::find($topico);
            $evento->situacion = 0;
            $evento->guardar();

            $pista = Pistas::where('topico', $topico);
            $resultados = [];
            foreach($pista as $pis){
                $pis->situacion = 0;
                $resultados[] = $pis->guardar();
            }

    
            if(!array_search(0, $resultados)){
                echo json_encode([
                    "mensaje" => "El Incidente de Desastres Naturales se elimino",
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