<?php

namespace Controllers;

use Model\Asesinatos;
use Model\Asesinados;
use Model\Evento;
use MVC\Router;
use Exception;

class AsesinatosController
{
    public static function guardar(){
        getHeadersApi();
        hasPermission(['AMC_ADMIN', 'AMC_COMANDO']);
                    
        $cantidadasesinados = count($_POST['nombre']);
        
        try {

            $evento = Evento::find($_POST['topico']);
            $evento->setInfo($_POST['info']);
            $evento->fuente = $_POST['fuente'];
            $evento->link = $_POST['link'];
            $evento->usuario = $_POST['usuario'];
            $evento->guardar();
 
            $asesinatos = new Asesinatos([
                'topico' => $_POST['topico'],
                'cant_per_asesinadas' => $cantidadasesinados,

            ]);

            if(!$asesinatos->validarExisteTopico()){
                $guardado = $asesinatos->guardar();
            }

            $resultados = [];
            for ($i=0; $i < $cantidadasesinados ; $i++) { 
                $asesinados = new Asesinados([
                    'id' =>  $_POST['id_per'][$i] != '' ? $_POST['id_per'][$i] : null ,
                    'topico' => $_POST['topico'],
                    'nombre' => $_POST['nombre'][$i],
                    'sexo' => $_POST['sexo'][$i],
                    'edad' => $_POST['edad'][$i],
                 
                ]);
                

                $guardado = $asesinados->guardar();
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

    public static function buscarAsesinatosAPI(){

     

   
        getHeadersApi();
        hasPermission(['AMC_ADMIN', 'AMC_COMANDO']);
     
        $topico = $_GET['topico'];

 
        try{
            $evento = Evento::find($topico);
            $evento->info = htmlspecialchars_decode($evento->info);
            $asesinados = Asesinados::fetchArray("SELECT * FROM amc_per_asesinadas where topico = $topico and situacion = 1;");

            echo json_encode([
                "asesinatos" => $evento,
                "asesinados" => $asesinados,
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

            $cantidadasesinados = count($_POST['nombre']);
            $resultados = [];
            for ($i=0; $i < $cantidadasesinados ; $i++) { 
                $asesinados = new Asesinados([
                    'id' =>  $_POST['id_per'][$i] != '' ? $_POST['id_per'][$i] : null ,
                    'topico' => $_POST['topico'],
                    'nombre' => $_POST['nombre'][$i],
                    'sexo' => $_POST['sexo'][$i],
                    'edad' => $_POST['edad'][$i],
                 
                ]);
                

                $guardado = $asesinados->guardar();
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

    public static function eliminarAsesinado(){
        getHeadersApi();
        hasPermission(['AMC_ADMIN', 'AMC_COMANDO']);
        
        try {
            $asesinado = asesinados::find($_POST['id']);
            $asesinado->situacion = 0;
            $resultado = $asesinado->guardar();
    
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

    public static function eliminarAsesinato(){
        getHeadersApi();
        hasPermission(['AMC_ADMIN', 'AMC_COMANDO']);
        
        try {

            $topico = $_POST['topico'];
            // ELIMINA EL TOPICO
            $evento = Evento::find($topico);
            $evento->situacion = 0;
            $evento->guardar();
            // ELIMINA LA CAPTURA
            $asesinatos = array_shift(asesinatos::where('topico', $topico));

            if($asesinatos){
                $asesinatos->situacion = 0;
                $asesinatos->guardar();

            }
            // ELIMINA LOS asesinados
            $asesinados = asesinados::where('topico', $topico);
            $resultados = [];
            foreach($asesinados as $asesinado){
                $asesinado->situacion = 0;
                $resultados[] = $asesinado->guardar();
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