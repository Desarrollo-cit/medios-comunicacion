<?php
namespace Controllers;


use Model\Evento;
use Model\IncautacionArmas;
use Model\IncautacionMunicion;
use Exception;
use MVC\Router;

class IncautacionArmasController
{
    public static function guardar(){
        getHeadersApi();

        try {

            $evento = Evento::find($_POST['topico']);
            $evento->setInfo($_POST['info']);
            $evento->guardar();

 
            $cantidadArmas = count($_POST['calibre']);
            $cantidadMunicion = count($_POST['calibre_municion']);
            $resultadosArmas = [];
            for ($i=0; $i < $cantidadArmas ; $i++) { 
                $armas = new IncautacionArmas([
                    'topico' => $_POST['topico'],
                    'tipo_arma' => $_POST['tipo'][$i],
                    'calibre' => $_POST['calibre'][$i],
                    'cantidad' => $_POST['cantidad'][$i],
            
                ]);
                

                $guardadoArmas = $armas->guardar();
                $resultadosArmas[] = $guardadoArmas['resultado'];
            }
            $resultadosMunicion = [];
            for ($i=0; $i < $cantidadMunicion ; $i++) { 
                $municion = new IncautacionMunicion([
                    'topico' => $_POST['topico'],
                    'calibre' => $_POST['calibre_municion'][$i],
                    'cantidad' => $_POST['cantidad_municion'][$i],
            
                ]);
                

                $guardadoMunicion = $municion->guardar();
                $resultadosMunicion[] = $guardadoMunicion['resultado'];
            }

            // echo json_encode($resultados);


            if(!array_search(0, $resultadosArmas) && !array_search(0, $resultadosMunicion)){
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

    public static function buscarIncautacionAPI(){
        getHeadersApi();
        $topico = $_GET['topico'];

        try{
            $evento = Evento::find($topico);
            $evento->info = htmlspecialchars_decode($evento->info);
            $armas = IncautacionArmas::consultarSQL("SELECT * FROM amc_detalle_arma where topico = $topico and situacion = 1 ");
            $municion = IncautacionMunicion::consultarSQL("SELECT * FROM amc_detalle_municion where topico = $topico and situacion = 1 ");
            // $capturados = Capturados::fetchArray("SELECT * FROM amc_per_capturadas where topico = $topico and situacion = 1;");

            echo json_encode([
                "evento" => $evento,
                "armas" => $armas,
                "municion" => $municion,
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
        // echo json_encode($_POST);
        // exit;
        
        try {

            $evento = Evento::find($_POST['topico']);
            $evento->setInfo($_POST['info']);
            $evento->guardar();

            // echo json_encode($resultado);
            // exit;
            $cantidadArmas = count($_POST['calibre']);
            $cantidadMunicion = count($_POST['calibre_municion']);
            $resultadosArmas = [];
            for ($i=0; $i < $cantidadArmas ; $i++) { 
                $armas = new IncautacionArmas([
                    'id' =>  $_POST['id_registro'][$i] != '' ? $_POST['id_registro'][$i] : null ,
                    'topico' => $_POST['topico'],
                    'tipo_arma' => $_POST['tipo'][$i],
                    'calibre' => $_POST['calibre'][$i],
                    'cantidad' => $_POST['cantidad'][$i],
            
                ]);
                

                $guardadoArmas = $armas->guardar();
                $resultadosArmas[] = $guardadoArmas['resultado'];
            }
            $resultadosMunicion = [];
            for ($i=0; $i < $cantidadMunicion ; $i++) { 
                $municion = new IncautacionMunicion([
                    'id' =>  $_POST['id_registro_municion'][$i] != '' ? $_POST['id_registro_municion'][$i] : null ,
                    'topico' => $_POST['topico'],
                    'calibre' => $_POST['calibre_municion'][$i],
                    'cantidad' => $_POST['cantidad_municion'][$i],
            
                ]);
                

                $guardadoMunicion = $municion->guardar();
                $resultadosMunicion[] = $guardadoMunicion['resultado'];
            }

            // echo json_encode($resultados);


            if(!array_search(0, $resultadosArmas) && !array_search(0, $resultadosMunicion)){
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

    public static function eliminarArma(){
        getHeadersApi();
        
        
        try {
            $arma = IncautacionArmas::find($_POST['id']);
            $arma->situacion = 0;
            $resultado = $arma->guardar();
    
            if($resultado['resultado'] == 1){
                echo json_encode([
                    "mensaje" => "El registro del arma se eliminó.",
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

    public static function eliminarMunicion(){
        getHeadersApi();
        
        
        try {
            $municion = IncautacionMunicion::find($_POST['id']);
            $municion->situacion = 0;
            $resultado = $municion->guardar();
    
            if($resultado['resultado'] == 1){
                echo json_encode([
                    "mensaje" => "El registro de la munición se eliminó.",
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

    public static function eliminarIncautacion(){
        getHeadersApi();
        
        
        try {

            $topico = $_POST['topico'];
            // ELIMINA EL TOPICO
            $evento = Evento::find($topico);
            $evento->situacion = 0;
            $evento->guardar();
           
            // ELIMINA LAS ARMAS
            $armas = IncautacionArmas::where('topico', $topico);
            $resultadosArmas = [];
            foreach($armas as $arma){
                $arma->situacion = 0;
                $resultadosArmas[] = $arma->guardar();
            }

            // ELIMINA LA MUNICION
            $municiones = IncautacionMunicion::where('topico', $topico);
            $resultadosMunicion = [];
            foreach($municiones as $municion){
                $municion->situacion = 0;
                $resultadosMunicion[] = $municion->guardar();
            }

    
            if(!array_search(0, $resultadosArmas) && !array_search(0, $resultadosMunicion)){
                echo json_encode([
                    "mensaje" => "La incautación se eliminó.",
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