<?php

namespace Controllers;

use Model\Migrantes;
use Model\Evento;
use MVC\Router;
use Exception;

class MigrantesController{
    public static function guardar(){
        hasPermissionApi(['AMC_ADMIN', 'AMC_COMANDO']);
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

            $evento = Evento::find($_POST['topic']);
            $evento->setInfo($_POST['info3']);
            $evento->fuente = $_POST['fuente'];
            $evento->link = $_POST['link'];
            $evento->usuario = $_POST['usuario'];
            $evento->guardar();
     

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
        hasPermissionApi(['AMC_ADMIN', 'AMC_COMANDO']);
        $topico = $_GET['topic'];


        try{

               
     
            $evento = Evento::find($topico);
            $evento->info = htmlspecialchars_decode($evento->info);
            $migrante = Migrantes::fetchArray("SELECT * FROM amc_migrantes where topic = $topico and situacion = 1;");


            echo json_encode(  
                ['migrantes' =>$evento,
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
        hasPermissionApi(['AMC_ADMIN', 'AMC_COMANDO']);

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
        hasPermissionApi(['AMC_ADMIN', 'AMC_COMANDO']);


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
    public static function modificar(){
        getHeadersApi();
        hasPermissionApi(['AMC_ADMIN', 'AMC_COMANDO']);
 
    
        $cantidadmigrantes = count($_POST['edad']);
        
        try {

            $evento = Evento::find($_POST['topic']);
            $evento->setInfo($_POST['info3']);
            $evento->fuente = $_POST['fuente'];
            $evento->link = $_POST['link'];
            $evento->usuario = $_POST['usuario'];
            $evento->guardar();
     

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
        hasPermissionApi(['AMC_ADMIN', 'AMC_COMANDO']);

        
        
        
        try {
            $migrante = migrantes::find($_POST['id']);
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
        hasPermissionApi(['AMC_ADMIN', 'AMC_COMANDO']);
        
        try {

            $topico = $_POST['topic'];
            // ELIMINA EL TOPICO
            $evento = Evento::find($topico);
            $evento->situacion = 0;
            $evento->guardar();

            $migrante = Migrantes::where('topic', $topico);
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