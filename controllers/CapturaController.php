<?php

namespace Controllers;

use Model\Captura;
use Model\Capturados;
use MVC\Router;
use Exception;

class CapturaController
{
    public static function guardar(){
        getHeadersApi();
        
        
        try {
            $captura = new Captura([
                'topico' => $_POST['topico'],
                'info' => $_POST['info'],
            ]);

            if(!$captura->validarExisteTopico()){
                $guardado = $captura->guardar();
            }
            
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
        $topico = $_GET['topico'];

        try{
            $captura = Captura::fetchArray("SELECT * FROM amc_capturas where topico = $topico and situacion = 1;");


            $capturados = Capturados::fetchArray("SELECT * FROM amc_per_capturadas where topico = $topico and situacion = 1;");

            echo json_encode([
                "captura" => array_shift($captura),
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
}