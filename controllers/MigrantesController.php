<?php

namespace Controllers;

use Model\Migrantes;
use Model\Evento;
use MVC\Router;
use Exception;

class MigrantesController{
    public static function guardar(){
        getHeadersApi();


        $cantidadmigrantes = count($_POST['edad']);

        if ($cantidadmigrantes == 0){

            echo json_encode([
                "mensaje" => "Debe llenar todos los campos",
                "codigo" => 5,
            ]);

            exit;


        }

    
        try {
     

            // if(!$asesinatos->validarExisteTopico()){
            //     $guardado = $asesinatos->guardar();
            // }

            $resultados = [];
            for ($i=0; $i < $cantidadmigrantes ; $i++) { 
                $migrantes = new Migrantes([
                    'id' =>  $_POST['id_mig'][$i] != '' ? $_POST['id_mig'][$i] : null ,
                    'topic' => $_POST['topic'],
                    'pais_migrante' => $_POST['pais_migrante'][$i],
                    'edad' => $_POST['edad'][$i],
                    'cantidad' => $_POST['cantidad'][$i],
                    'sexo' => $_POST['sexo'][$i],
                    'lugar_ingreso' => $_POST['lugar_ingreso'][$i],
                    'destino' => $_POST['destino'][$i],
                    'info' => $_POST['info3'],
                 
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

    public static function buscarMigrantesAPI(){

        getHeadersApi();

        $topico = $_GET['topic'];


        try{

               
     
            $migrantes = Migrantes::fetchArray("SELECT * FROM amc_migrantes where topic = $topico and situacion = 1;");

            $migrante = Migrantes::fetchArray("SELECT * FROM amc_migrantes where topic = $topico and situacion = 1;");


            echo json_encode(  
                ['migrantes' =>array_shift($migrantes),
                'migrante' => $migrante,

            
            
            ]);

        } catch (Exception $e) {
            echo json_encode([
                "detalle" => $e->getMessage(),       
                "mensaje" => "Ocurrió  un error en base de datos.",

                "codigo" => 4,
            ]);
        }
    }

    public static function buscarEdadAPI(){

        getHeadersApi();



        try{

               
     
            $edad = Migrantes::fetchArray("SELECT * FROM amc_edades where situacion  = 1 ;");


            echo json_encode($edad);

        } catch (Exception $e) {
            echo json_encode([
                "detalle" => $e->getMessage(),       
                "mensaje" => "Ocurrió  un error en base de datos.",

                "codigo" => 4,
            ]);
        }
    }

    public static function buscarPaisAPI(){

        getHeadersApi();



        try{

               
     
            $pais = Migrantes::fetchArray("SELECT * FROM paises;");


            echo json_encode($pais);

        } catch (Exception $e) {
            echo json_encode([
                "detalle" => $e->getMessage(),       
                "mensaje" => "Ocurrió  un error en base de datos.",

                "codigo" => 4,
            ]);
        }
    }
    // public static function modificar(){
    //     getHeadersApi();
        
        
    //     try {

    //         $busquedaAsesinato = Migrantes::where( 'topico' , $_POST['topico']);
    //         $asesinato = array_shift($busquedaAsesinato);
 

    //         $asesinato->info = $_POST['info'];
    //         $asesinato->guardar();

    //         // echo json_encode($resultado);
    //         // exit;

    //         $cantidadasesinados = count($_POST['nombre']);
    //         $resultados = [];
    //         for ($i=0; $i < $cantidadasesinados ; $i++) { 
    //             $asesinados = new Asesinados([
    //                 'id' =>  $_POST['id_per'][$i] != '' ? $_POST['id_per'][$i] : null ,
    //                 'topico' => $_POST['topico'],
    //                 'nombre' => $_POST['nombre'][$i],
    //                 'sexo' => $_POST['sexo'][$i],
    //                 'edad' => $_POST['edad'][$i],
                 
    //             ]);
                

    //             $guardado = $asesinados->guardar();
    //             $resultados[] = $guardado['resultado'];
    //         }



    //         if(!array_search(0, $resultados)){
    //             echo json_encode([
    //                 "mensaje" => "El registro se modificó.",
    //                 "codigo" => 1,
    //             ]);
                
    //         }else{
    //             echo json_encode([
    //                 "mensaje" => "Ocurrió  un error.",
    //                 "codigo" => 0,
    //             ]);
    
    //         }
    //     } catch (Exception $e) {
    //         echo json_encode([
    //             "detalle" => $e->getMessage(),       
    //             "mensaje" => "Ocurrió  un error en base de datos.",

    //             "codigo" => 4,
    //         ]);
    //     }
    // }

    public static function eliminarMigrante(){
        getHeadersApi();
        
        
        try {
            $migrante = migrantes::find($_POST['id']);
            $migrante->situacion = 0;
            $resultado = $migrante->guardar();
    
            if($resultado['resultado'] == 1){
                echo json_encode([
                    "mensaje" => "El registro del asesinado se eliminó.",
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

    // public static function eliminarAsesinato(){
    //     getHeadersApi();
        
        
    //     try {

    //         $topico = $_POST['topico'];
    //         // ELIMINA EL TOPICO
    //         $evento = Evento::find($topico);
    //         $evento->situacion = 0;
    //         $evento->guardar();
    //         // ELIMINA LA CAPTURA
    //         $Migrantes = array_shift(Migrantes::where('topico', $topico));

    //         if($Migrantes){
    //             $Migrantes->situacion = 0;
    //             $Migrantes->guardar();

    //         }
    //         // ELIMINA LOS asesinados
    //         $asesinados = asesinados::where('topico', $topico);
    //         $resultados = [];
    //         foreach($asesinados as $asesinado){
    //             $asesinado->situacion = 0;
    //             $resultados[] = $asesinado->guardar();
    //         }

    
    //         if(!array_search(0, $resultados)){
    //             echo json_encode([
    //                 "mensaje" => "La captura se eliminó.",
    //                 "codigo" => 1,
    //             ]);
                
    //         }else{
    //             echo json_encode([
    //                 "mensaje" => "Ocurrió  un error.",
    //                 "codigo" => 0,
    //             ]);
    
    //         }
    //     } catch (Exception $e) {
    //         echo json_encode([
    //             "detalle" => $e->getMessage(),       
    //             "mensaje" => "Ocurrió  un error en base de datos.",

    //             "codigo" => 4,
    //         ]);
    //     }
    // } 

}