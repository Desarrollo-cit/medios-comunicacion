<?php

namespace Controllers;

use Model\Des_natural;
use Model\Evento;
use MVC\Router;
use Exception;
use Model\Desastre_natural;

class Des_naturalController{
    public static function guardar(){
        getHeadersApi();


    
        try {

            $evento = Evento::find($_POST['topico']);
            $evento->setInfo($_POST['info6']);
            $evento->fuente = $_POST['fuente'];
            $evento->link = $_POST['link'];
            $evento->usuario = $_POST['usuario'];
            $evento->guardar();
     

            $resultados = [];

                $desastres = new Des_natural([
                    
                    'topico' => $_POST['topico'],
                    'tipo' => $_POST['tipo'],
                    'nombre_desastre' => $_POST['nombre_desastre'],
                    'per_fallecida' => $_POST['per_fallecida'],
                    'per_evacuada' => $_POST['per_evacuada'],
                    'per_afectada' => $_POST['per_afectada'],
                    'albergues' => $_POST['albergues'],
                    'est_colapsadas' => $_POST['est_colapsadas'],
                    'inundaciones' => $_POST['inundaciones'],
                    'derrumbes' => $_POST['derrumbes'],
                    'carre_colap' => $_POST['carre_colap'],
                    'hectareas_quemadas' => $_POST['hectareas_quemadas'],
                    'rios' => $_POST['rios'],

                  
                 
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

public static function buscarDesastresAPI(){

    getHeadersApi();
    $topico = $_GET['topico'];
    // echo json_encode("hola");
    // exit;



  

        try{

               
     
            $evento = Evento::find($topico);
            $evento->info = htmlspecialchars_decode($evento->info);
            $desastre = Des_natural::fetchArray("SELECT * FROM amc_desastre_natural where topico = $topico and situacion = 1;");


            echo json_encode(  
                ['info' =>$evento,
                'desastre' => $desastre,

            
            
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
            $evento->setInfo($_POST['info6']);
            $evento->fuente = $_POST['fuente'];
            $evento->link = $_POST['link'];
            $evento->usuario = $_POST['usuario'];
            $evento->guardar();
     

            $resultados = [];

                $desastres = new Des_natural([
                    'id' =>  $_POST['id']!= '' ? $_POST['id']: null ,
                    'topico' => $_POST['topico'],
                    'tipo' => $_POST['tipo'],
                    'nombre_desastre' => $_POST['nombre_desastre'],
                    'per_fallecida' => $_POST['per_fallecida'],
                    'per_evacuada' => $_POST['per_evacuada'],
                    'per_afectada' => $_POST['per_afectada'],
                    'albergues' => $_POST['albergues'],
                    'est_colapsadas' => $_POST['est_colapsadas'],
                    'inundaciones' => $_POST['inundaciones'],
                    'derrumbes' => $_POST['derrumbes'],
                    'carre_colap' => $_POST['carre_colap'],
                    'hectareas_quemadas' => $_POST['hectareas_quemadas'],
                    'rios' => $_POST['rios'],

                  
                 
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



    public static function eliminarDesastre(){
        getHeadersApi();
        
        
        try {

            $topico = $_POST['topico'];
            // ELIMINA EL TOPICO
            $evento = Evento::find($topico);
            $evento->situacion = 0;
            $evento->guardar();

            $desastre = Des_natural::where('topico', $topico);
            $resultados = [];
            foreach($desastre as $des){
                $des->situacion = 0;
                $resultados[] = $des->guardar();
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