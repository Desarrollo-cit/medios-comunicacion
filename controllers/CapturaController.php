<?php

namespace Controllers;

use Model\Captura;
use Model\Capturados;
use Model\Evento;
use MVC\Router;
use Exception;

class CapturaController
{
    public static function guardar(){
        getHeadersApi();
        hasPermission(['AMC_ADMIN', 'AMC_COMANDO']);
        
        try {

            $evento = Evento::find($_POST['topico']);
            $evento->setInfo($_POST['info']);
            $evento->fuente = $_POST['fuente'];
            $evento->link = $_POST['link'];
            $evento->usuario = $_POST['usuario'];
            $evento->guardar();
 
            $cantidadCapturados = count($_POST['nombre']);
            $resultados = [];
            for ($i=0; $i < $cantidadCapturados ; $i++) { 
                $capturado = new Capturados([
                    'topico' => $_POST['topico'],
                    'nacionalidad' => $_POST['nacionalidad'][$i],
                    'sexo' => $_POST['sexo'][$i],
                    'nombre' => $_POST['nombre'][$i],
                    'edad' => $_POST['edad'][$i],
                    'delito' => $_POST['delito'][$i],
                    'vinculo' => $_POST['vinculo'][$i],
                ]);
                

                $guardado = $capturado->guardar();
                $resultados[] = $guardado['resultado'];
            }

            // echo json_encode($resultados);


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

    public static function buscarCapturaAPI(){
        getHeadersApi();
        hasPermission(['AMC_ADMIN', 'AMC_COMANDO']);
        $topico = $_GET['topico'];

        try{
            $evento = Evento::find($topico);
            $evento->info = htmlspecialchars_decode($evento->info);


            $capturados = Capturados::fetchArray("SELECT * FROM amc_per_capturadas where topico = $topico and situacion = 1;");

            echo json_encode([
                "captura" => $evento,
                "capturados" => $capturados,
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
        hasPermission(['AMC_ADMIN', 'AMC_COMANDO']);
        
        try {

            $evento = Evento::find($_POST['topico']);

            $evento->setInfo($_POST['info']);
            $evento->fuente = $_POST['fuente'];
            $evento->link = $_POST['link'];
            $evento->usuario = $_POST['usuario'];
            $evento->guardar();

            // echo json_encode($resultado);
            // exit;

            
            $cantidadCapturados = count($_POST['nombre']);
            $resultados = [];
            for ($i=0; $i < $cantidadCapturados ; $i++) { 
                $capturado = new Capturados([
                    'id' =>  $_POST['id_per'][$i] != '' ? $_POST['id_per'][$i] : null ,
                    'topico' => $_POST['topico'],
                    'nacionalidad' => $_POST['nacionalidad'][$i],
                    'sexo' => $_POST['sexo'][$i],
                    'nombre' => $_POST['nombre'][$i],
                    'edad' => $_POST['edad'][$i],
                    'delito' => $_POST['delito'][$i],
                    'vinculo' => $_POST['vinculo'][$i],
                ]);
                

                $guardado = $capturado->guardar();
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

    public static function eliminarCapturado(){
        getHeadersApi();
        hasPermission(['AMC_ADMIN', 'AMC_COMANDO']);
        
        try {
            $capturado = Capturados::find($_POST['id']);
            $capturado->situacion = 0;
            $resultado = $capturado->guardar();
    
            if($resultado['resultado'] == 1){
                echo json_encode([
                    "mensaje" => "El registro del capturado se eliminó.",
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

    public static function eliminarCaptura(){
        getHeadersApi();
        hasPermission(['AMC_ADMIN', 'AMC_COMANDO']);
        
        try {

            $topico = $_POST['topico'];
            // ELIMINA EL TOPICO
            $evento = Evento::find($topico);
            $evento->situacion = 0;
            $evento->guardar();
            // ELIMINA LA CAPTURA
            $captura = array_shift(Captura::where('topico', $topico));

            if($captura){
                $captura->situacion = 0;
                $captura->guardar();

            }
            // ELIMINA LOS CAPTURADOS
            $capturados = Capturados::where('topico', $topico);
            $resultados = [];
            foreach($capturados as $capturado){
                $capturado->situacion = 0;
                $resultados[] = $capturado->guardar();
            }

    
            if(!array_search(0, $resultados)){
                echo json_encode([
                    "mensaje" => "La captura se eliminó.",
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